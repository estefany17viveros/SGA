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

    public function create(Request $request)
    {
        $student = null;

        if ($request->student_id) {
            $student = Student::findOrFail($request->student_id);
        }

        $grades = Grade::orderBy('level')->get();

        $groups = [];
        if ($request->grade_id) {
            $groups = Group::where('grade_id', $request->grade_id)->get();
        }

        $year = AcademicYear::where('status', 'activo')->first();

        if (!$year) {
            return back()->with('error', '❌ No hay año académico activo.');
        }

        $students = null;
        if (!$student) {
            $students = Student::orderBy('first_name')->get();
        }

        return view('admin.enrollments.create', compact(
            'student',
            'students',
            'grades',
            'groups',
            'year'
        ));
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'student_id' => 'required|exists:students,id',
                'grade_id' => 'required|exists:grades,id',
                'group_id' => 'nullable'
            ]);

            $graduated = Enrollment::where('student_id', $request->student_id)
                ->where('status', 'graduado')
                ->exists();

            if ($graduated) {
                return back()->with('error', '❌ Este estudiante ya está graduado.');
            }

            $year = AcademicYear::where('status', 'activo')->first();

            if (!$year) {
                return back()->with('error', '❌ No hay un año académico activo.');
            }

            $exists = Enrollment::where('student_id', $request->student_id)
                ->where('academic_year_id', $year->id)
                ->exists();

            if ($exists) {
                return back()->with('error', '⚠️ Ya está matriculado en este año.');
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

    public function show(Enrollment $enrollment)
    {
        $enrollment->load(['student', 'grade', 'group', 'academicYear']);
        return view('admin.enrollments.show', compact('enrollment'));
    }

    public function edit(Enrollment $enrollment)
    {
        if ($enrollment->status == 'graduado') {
            return back()->with('error','❌ No se puede editar un graduado.');
        }

        $students = Student::orderBy('first_name')->get();
        $grades = Grade::orderBy('level')->get();
        $groups = Group::where('grade_id', $enrollment->grade_id)->get();

        return view('admin.enrollments.edit', compact('enrollment', 'students', 'grades', 'groups'));
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        if ($enrollment->status == 'graduado') {
            return back()->with('error','❌ No se puede editar un graduado.');
        }

        $request->validate([
            'grade_id' => 'required|exists:grades,id',
            'group_id' => 'nullable',
            'status' => 'required|in:matriculado,aprobado,reprobado,retirado,graduado'
        ]);

        // ✅ YA NO GRADÚA AUTOMÁTICAMENTE
        $enrollment->update([
            'grade_id' => $request->grade_id,
            'group_id' => $request->group_id,
            'status' => $request->status
        ]);

        return redirect()->route('admin.enrollments.index')
            ->with('success', 'Matrícula actualizada');
    }

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

            // ✅ YA NO GRADÚA AUTOMÁTICAMENTE
            $enrollment->status = $request->status;
            $enrollment->save();

            return back()->with('success','✅ Estado actualizado.');

        } catch (\Exception $e) {
            return back()->with('error','❌ Error al actualizar estado.');
        }
    }
public function promoteStudents()
{
    // 🔥 1. obtener último año registrado
    $lastYear = AcademicYear::orderBy('id','desc')->first();

    if (!$lastYear) {
        return back()->with('error','No hay años académicos');
    }

    // 🔥 2. crear nuevo año automáticamente
    $newYear = AcademicYear::create([
        'year' => $lastYear->year + 1,
        'status' => 'activo'
    ]);

    // 🔥 3. desactivar el anterior
    $lastYear->update(['status' => 'inactivo']);

    // 🔥 4. traer estudiantes del año anterior
    $enrollments = Enrollment::where('academic_year_id', $lastYear->id)->get();

    foreach ($enrollments as $enrollment) {

        // ❌ ignorar retirados
        if ($enrollment->status == 'retirado') {
            continue;
        }

        // 🎓 GRADUAR
        if ($enrollment->status == 'aprobado' && $enrollment->grade->level == 11) {

            $enrollment->update(['status' => 'graduado']);
            continue;
        }

        $gradeId = $enrollment->grade_id;

        // ✅ SUBIR DE GRADO
        if ($enrollment->status == 'aprobado') {

            $nextGrade = Grade::where('level', $enrollment->grade->level + 1)->first();

            if ($nextGrade) {
                $gradeId = $nextGrade->id;
            }
        }

        // 🔁 REPROBADO → MISMO GRADO
        if ($enrollment->status == 'reprobado') {
            $gradeId = $enrollment->grade_id;
        }

        // 🔥 CREAR NUEVA MATRÍCULA SIEMPRE
        Enrollment::create([
            'student_id' => $enrollment->student_id,
            'grade_id' => $gradeId,
            'group_id' => null,
            'academic_year_id' => $newYear->id,

            // 🔥 IMPORTANTE
            'status' => $enrollment->status == 'reprobado'
                ? 'reprobado'
                : 'matriculado'
        ]);
    }

    return back()->with('success','Año cerrado correctamente, estudiantes promovidos');
}
    public function destroy(Enrollment $enrollment)
    {
        if ($enrollment->status == 'graduado') {
            return back()->with('error','❌ No se puede eliminar un graduado.');
        }

        $enrollment->delete();

        return back()->with('success','Eliminado correctamente');
    }

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

                // ✅ SOLO APROBADO (NO GRADUADO)
                $enrollment->status = 'aprobado';
                $enrollment->save();
            }

            return back()->with('success','Todos aprobados (sin graduar)');

        } catch (\Exception $e) {
            return back()->with('error','Error');
        }
    }
}