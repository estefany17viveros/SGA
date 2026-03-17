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
        ->where(function($q) use ($currentYear) {
            $q->where('academic_year_id', $currentYear->id) // Matrículas del año activo
              ->orWhere(function($q2) use ($currentYear) {
                  // Agregamos reprobados del año anterior
                  $previousYear = AcademicYear::where('id','<',$currentYear->id)->orderBy('id','desc')->first();
                  if($previousYear){
                      $q2->where('academic_year_id',$previousYear->id)
                         ->where('status','reprobado');
                  }
              });
        });

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

        $year = AcademicYear::where('status', 'activo')->first();

        if (!$year) {
            return back()->with('error', '❌ No hay un año académico activo.');
        }

        $exists = Enrollment::where('student_id', $request->student_id)
            ->where('academic_year_id', $year->id)
            ->exists();

        if ($exists) {
            return back()->with('error', '⚠️ Este estudiante ya está matriculado en el año académico actual.');
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

        return back()->with('error', '❌ Ocurrió un error al registrar la matrícula.');
    }
}

    /**
     * MOSTRAR MATRÍCULA
     */
    public function show(Enrollment $enrollment)
    {
        $enrollment->load(['student', 'grade', 'group', 'academicYear']);
        return view('admin.enrollments.show', compact('enrollment'));
    }

    /**
     * FORMULARIO EDITAR
     */
    public function edit(Enrollment $enrollment)
    {
        $students = Student::orderBy('first_name')->get();
        $grades = Grade::orderBy('level')->get();
        $groups = Group::where('grade_id', $enrollment->grade_id)->get();

        return view('admin.enrollments.edit', compact('enrollment', 'students', 'grades', 'groups'));
    }

    /**
     * ACTUALIZAR MATRÍCULA
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'grade_id' => 'required|exists:grades,id',
            'group_id' => 'nullable',
            'status' => 'required|in:matriculado,aprobado,reprobado,retirado'
        ]);

        $enrollment->update([
            'grade_id' => $request->grade_id,
            'group_id' => $request->group_id,
            'status' => $request->status
        ]);

        return redirect()->route('admin.enrollments.index')
            ->with('success', 'Matrícula actualizada');
    }

    /**
     * ACTUALIZAR ESTADO (APROBADO / REPROBADO / RETIRADO)
     */
public function updateStatus(Request $request, $id)
{
    try {

        $enrollment = Enrollment::findOrFail($id);

        $request->validate([
            'status' => 'required|in:matriculado,aprobado,reprobado,retirado'
        ]);

        $currentYear = AcademicYear::where('status','activo')->first();

        if(!$currentYear){
            return back()->with('error','❌ No existe un año académico activo.');
        }

        if ($request->status == 'aprobado' && $enrollment->academic_year_id != $currentYear->id) {
            $enrollment->academic_year_id = $currentYear->id;
        }

        $enrollment->status = $request->status;
        $enrollment->save();

        return back()->with('success','✅ Estado actualizado correctamente.');

    } catch (\Exception $e) {

        return back()->with('error','❌ No se pudo actualizar el estado.');
    }
}

    /**
     * PROMOVER ESTUDIANTES AL NUEVO AÑO
     */
    public function promoteStudents()
    {
        $currentYear = AcademicYear::where('status', 'activo')->first();
        if (!$currentYear) {
            return back()->with('error', 'No hay año académico activo');
        }

        $lastYear = AcademicYear::where('id', '<', $currentYear->id)
            ->orderBy('id', 'desc')
            ->first();

        if (!$lastYear) {
            return back()->with('error', 'No existe un año anterior');
        }

        $students = Enrollment::where('academic_year_id', $lastYear->id)->get();

        foreach ($students as $enrollment) {

            if ($enrollment->status == 'retirado') {
                continue; // No promocionar retirados
            }

            $gradeId = $enrollment->grade_id;

            if ($enrollment->status == 'aprobado') {
                $nextGrade = Grade::where('level', $enrollment->grade->level + 1)->first();
                if ($nextGrade) {
                    $gradeId = $nextGrade->id;
                }
            }

            if ($enrollment->status == 'reprobado') {
                $gradeId = $enrollment->grade_id; // repite el mismo grado
            }

            // Evitar duplicados
            $exists = Enrollment::where('student_id', $enrollment->student_id)
                ->where('academic_year_id', $currentYear->id)
                ->exists();

            if (!$exists) {
                Enrollment::create([
                    'student_id' => $enrollment->student_id,
                    'grade_id' => $gradeId,
                    'group_id' => null,
                    'academic_year_id' => $currentYear->id,
                    'status' => 'matriculado'
                ]);
            }
        }

        return back()->with('success', 'Promoción realizada correctamente');
    }

    /**
     * ELIMINAR MATRÍCULA
     */
    public function destroy(Enrollment $enrollment)
{
    try {

        $enrollment->delete();

        return back()->with('success','✅ Matrícula eliminada correctamente.');

    } catch (\Exception $e) {

        return back()->with('error','❌ No se pudo eliminar la matrícula.');
    }
}
}