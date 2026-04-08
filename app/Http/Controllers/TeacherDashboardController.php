<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\TeacherSubject;
use App\Models\Student;
use App\Models\AcademicYear;

class TeacherDashboardController extends Controller
{
    /**
     * 📚 DASHBOARD: MATERIAS DEL DOCENTE
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user || !$user->teacher) {
            abort(403, 'No autorizado');
        }

        $teacher = $user->teacher;

        // Año activo
        $year = AcademicYear::where('status', 'activo')->first();

        if (!$year) {
            return back()->with('error', 'No hay año académico activo');
        }

        // Asignaciones del docente
        $assignments = TeacherSubject::with(['subject', 'grade'])
            ->where('teacher_id', $teacher->id)
            ->where('academic_year_id', $year->id)
            ->get();

        $data = [];

        foreach ($assignments as $assignment) {

            if (!$assignment->subject || !$assignment->grade) {
                continue;
            }

            $subjectId = $assignment->subject->id;

            if (!isset($data[$subjectId])) {
                $data[$subjectId] = [
                    'subject_id' => $subjectId,
                    'subject' => $assignment->subject->name,
                    'grades' => []
                ];
            }

            // Obtener estudiantes del grado en el año activo
            $students = Student::whereHas('enrollments', function ($query) use ($assignment, $year) {
                $query->where('grade_id', $assignment->grade_id)
                      ->where('academic_year_id', $year->id);
            })->get();

            $data[$subjectId]['grades'][] = [
                'grade_id' => $assignment->grade->id,
                'grade_name' => $assignment->grade->name,
                'students' => $students
            ];
        }

        $data = array_values($data);

        return view('teacher.dashboard', compact('data'));
    }

    /**
     * 🎓 GRADOS POR MATERIA
     */
    public function grades($subjectId)
    {
        $user = Auth::user();

        if (!$user || !$user->teacher) {
            abort(403);
        }

        $teacher = $user->teacher;

        $year = AcademicYear::where('status', 'activo')->first();

        if (!$year) {
            return back()->with('error', 'No hay año académico activo');
        }

        $assignments = TeacherSubject::with(['grade'])
            ->where('teacher_id', $teacher->id)
            ->where('academic_year_id', $year->id)
            ->where('subject_id', $subjectId)
            ->get();

        $grades = [];

        foreach ($assignments as $assignment) {
            if (!$assignment->grade) continue;

            $grades[] = [
                'grade_id' => $assignment->grade->id,
                'grade_name' => $assignment->grade->name
            ];
        }

        return view('teacher.grades', [
            'assignments' => $grades,
            'subjectId' => $subjectId
        ]);
    }

    /**
     * 👨‍🎓 ESTUDIANTES POR GRADO
     */
    public function students($subjectId, $gradeId)
{
    $user = Auth::user();

    if (!$user || !$user->teacher) {
        abort(403);
    }

    $teacher = $user->teacher;

    $year = AcademicYear::where('status', 'activo')->first();

    if (!$year) {
        return back()->with('error', 'No hay año académico activo');
    }

    // 👨‍🎓 Estudiantes
    $students = Student::whereHas('enrollments', function ($query) use ($gradeId, $year) {
        $query->where('grade_id', $gradeId)
              ->where('academic_year_id', $year->id);
    })->get();

    // 🔥 AQUÍ ESTÁ LA CLAVE
    $teacherSubject = TeacherSubject::where('teacher_id', $teacher->id)
        ->where('subject_id', $subjectId)
        ->where('grade_id', $gradeId)
        ->where('academic_year_id', $year->id)
        ->first();

    if (!$teacherSubject) {
        abort(404, 'Asignación no encontrada');
    }

    return view('teacher.students', [
        'students' => $students,
        'subjectId' => $subjectId,
        'gradeId' => $gradeId,
        'teacher_subject_id' => $teacherSubject->id // 🔥 YA LO ENVÍAS
    ]);
}
}