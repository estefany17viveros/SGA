<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Grade;
use App\Models\Group;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{

    /**
     * LISTAR MATRÍCULAS DEL AÑO ACTIVO
     */
    public function index(Request $request)
    {
        $currentYear = AcademicYear::where('status','activo')->first();

        if(!$currentYear){
            return back()->with('error','No hay año académico activo');
        }

        $query = Enrollment::with(['student','grade','group','academicYear'])
            ->where('academic_year_id', $currentYear->id);

        if($request->grade_id){
            $query->where('grade_id',$request->grade_id);
        }

        $enrollments = $query->get();
        $grades = Grade::orderBy('level')->get();

        return view('admin.enrollments.index',compact('enrollments','grades','currentYear'));
    }

    /**
     * FORMULARIO CREAR MATRÍCULA
     */
    public function create(Request $request)
    {
        $students = Student::orderBy('first_name')->get();
        $grades = Grade::orderBy('level')->get();

        $groups = [];
        if ($request->grade_id) {
            $groups = Group::where('grade_id', $request->grade_id)->get();
        }

        $year = AcademicYear::where('status', 'activo')->first();

        return view('admin.enrollments.create', compact('students', 'grades', 'groups', 'year'));
    }

    /**
     * GUARDAR MATRÍCULA
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'student_id' => 'required|exists:students,id',
                'grade_id' => 'required|exists:grades,id',
                'group_id' => 'nullable'
            ]);

            // 🔒 BLOQUEO: estudiante ya graduado
            $graduated = Enrollment::where('student_id', $request->student_id)
                ->where('status', 'graduado')
                ->exists();

            if ($graduated) {
                return back()->with('error', '❌ Este estudiante ya está graduado y no puede matricularse nuevamente.');
            }

            $year = AcademicYear::where('status', 'activo')->first();

            if (!$year) {
                return back()->with('error', '❌ No hay un año académico activo.');
            }

            $exists = Enrollment::where('student_id', $request->student_id)
                ->where('academic_year_id', $year->id)
                ->exists();

            if ($exists) {
                return back()->with('error', '⚠️ Este estudiante ya está matriculado en el año actual.');
            }

            Enrollment::create([
                'student_id' => $request->student_id,
                'grade_id' => $request->grade_id,
                'group_id' => $request->group_id,
                'academic_year_id' => $year->id,
                'status' => 'matriculado'
            ]);

            return redirect()->route('admin.enrollments.index')
                ->with('success', '✅ Matrícula creada correctamente.');

        } catch (\Exception $e) {
            return back()->with('error', '❌ Error al registrar matrícula.');
        }
    }

    /**
     * MOSTRAR
     */
    public function show(Enrollment $enrollment)
    {
        $enrollment->load(['student', 'grade', 'group', 'academicYear']);
        return view('admin.enrollments.show', compact('enrollment'));
    }

    /**
     * EDITAR
     */
    public function edit(Enrollment $enrollment)
    {
        if ($enrollment->status == 'graduado') {
            return back()->with('error','❌ No se puede editar un estudiante graduado.');
        }

        $students = Student::orderBy('first_name')->get();
        $grades = Grade::orderBy('level')->get();
        $groups = Group::where('grade_id', $enrollment->grade_id)->get();

        return view('admin.enrollments.edit', compact('enrollment', 'students', 'grades', 'groups'));
    }

    /**
     * ACTUALIZAR
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        if ($enrollment->status == 'graduado') {
            return back()->with('error','❌ No se puede editar un estudiante graduado.');
        }

        $request->validate([
            'grade_id' => 'required|exists:grades,id',
            'group_id' => 'nullable',
            'status' => 'required|in:matriculado,aprobado,reprobado,retirado,graduado'
        ]);

        // 🎓 auto graduación
        if ($request->status == 'aprobado' && $enrollment->grade->level == 11) {
            $status = 'graduado';
        } else {
            $status = $request->status;
        }

        $enrollment->update([
            'grade_id' => $request->grade_id,
            'group_id' => $request->group_id,
            'status' => $status
        ]);

        return redirect()->route('admin.enrollments.index')
            ->with('success', 'Matrícula actualizada');
    }

    /**
     * ACTUALIZAR ESTADO
     */
    public function updateStatus(Request $request, $id)
    {
        try {

            $enrollment = Enrollment::findOrFail($id);

            if ($enrollment->status == 'graduado') {
                return back()->with('error','❌ No se puede modificar un graduado.');
            }

            $request->validate([
                'status' => 'required|in:matriculado,aprobado,reprobado,retirado,graduado'
            ]);

            if ($request->status == 'aprobado' && $enrollment->grade->level == 11) {
                $enrollment->status = 'graduado';
            } else {
                $enrollment->status = $request->status;
            }

            $enrollment->save();

            return back()->with('success','✅ Estado actualizado.');

        } catch (\Exception $e) {
            return back()->with('error','❌ Error al actualizar estado.');
        }
    }

    /**
     * PROMOVER
     */
    public function promoteStudents()
    {
        $currentYear = AcademicYear::where('status', 'activo')->first();

        if (!$currentYear) {
            return back()->with('error', 'No hay año activo');
        }

        $lastYear = AcademicYear::where('id','<',$currentYear->id)
            ->orderBy('id','desc')
            ->first();

        if (!$lastYear) {
            return back()->with('error','No hay año anterior');
        }

        $students = Enrollment::where('academic_year_id',$lastYear->id)->get();

        foreach ($students as $enrollment) {

            if ($enrollment->status == 'retirado' || $enrollment->status == 'graduado') {
                continue;
            }

            $gradeId = $enrollment->grade_id;

            if ($enrollment->status == 'aprobado') {
                $nextGrade = Grade::where('level',$enrollment->grade->level + 1)->first();
                if ($nextGrade) {
                    $gradeId = $nextGrade->id;
                }
            }

            $exists = Enrollment::where('student_id',$enrollment->student_id)
                ->where('academic_year_id',$currentYear->id)
                ->exists();

            if (!$exists) {
                Enrollment::create([
                    'student_id'=>$enrollment->student_id,
                    'grade_id'=>$gradeId,
                    'group_id'=>null,
                    'academic_year_id'=>$currentYear->id,
                    'status'=>'matriculado'
                ]);
            }
        }

        return back()->with('success','Promoción realizada');
    }

    /**
     * ELIMINAR
     */
    public function destroy(Enrollment $enrollment)
    {
        if ($enrollment->status == 'graduado') {
            return back()->with('error','❌ No se puede eliminar un graduado.');
        }

        $enrollment->delete();

        return back()->with('success','Eliminado correctamente');
    }

     /**
     * APROBAR TODOS
     */
    
    public function approveAll()
    {
        try {

            $currentYear = AcademicYear::where('status','activo')->first();

            if(!$currentYear){
                return back()->with('error','No hay año activo');
            }

            $enrollments = Enrollment::where('academic_year_id',$currentYear->id)->get();

            foreach ($enrollments as $enrollment) {

                if($enrollment->status !== 'matriculado'){
                    continue;
                }

                // ✅ TODOS a aprobado
                $enrollment->status = 'aprobado';
                $enrollment->save();
            }

            return back()->with('success','Todos aprobados');

        } catch (\Exception $e) {
            return back()->with('error','Error');
        }
    }
    /**
     * GRADUADOS (CON PAGINACIÓN Y FILTROS)
     */
    public function graduated(Request $request)
{
    $query = Enrollment::with(['student','grade','group','academicYear'])
    ->where(function($query){

        $query->where('status','graduado')

        ->orWhere(function($q){
            $q->whereHas('grade', function($g){
                $g->where('level',11);
            })
            ->where('status','aprobado'); // ✅ CLAVE AQUÍ
        });

    });

    if($request->last_name){
        $query->whereHas('student', function($q) use ($request){
            $q->where('last_name','like','%'.$request->last_name.'%');
        });
    }

    if($request->year){
        $query->whereHas('academicYear', function($q) use ($request){
            $q->where('year',$request->year);
        });
    }

    $enrollments = $query->orderBy('academic_year_id','desc')
        ->paginate(10)
        ->withQueryString();

    $years = AcademicYear::orderBy('year','desc')->get();

    return view('admin.enrollments.graduated', compact('enrollments','years'));
}
    /**
 * LISTAR RETIRADOS
 */
public function retired(Request $request)
{
    $query = Enrollment::with([
        'student',
        'grade',
        'group',
        'academicYear'
    ])
    ->where('status','retirado');

    // 🔎 FILTRO POR APELLIDO
    if($request->last_name){
        $query->whereHas('student', function($q) use ($request){
            $q->where('last_name','like','%'.$request->last_name.'%');
        });
    }

    // 📅 FILTRO POR AÑO
    if($request->year){
        $query->whereHas('academicYear', function($q) use ($request){
            $q->where('year',$request->year);
        });
    }

    $enrollments = $query->orderBy('academic_year_id','desc')
        ->paginate(10)
        ->withQueryString();

    $years = AcademicYear::orderBy('year','desc')->get();

    return view('admin.enrollments.retired', compact('enrollments','years'));
}
}