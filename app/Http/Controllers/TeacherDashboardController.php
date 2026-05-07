<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\TeacherSubject;
use App\Models\Student;
use App\Models\AcademicYear;
use App\Models\Grade;
use App\Models\DisciplinaryNote;

class TeacherDashboardController extends Controller
{
    /**
     * =========================
     * 📚 DASHBOARD PRINCIPAL
     * =========================
     */
    public function index()
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            abort(403, 'No autorizado');
        }

        $year = AcademicYear::where('status', 'activo')->first();

        if (!$year) {
            return back()->with('error', 'No hay año académico activo');
        }

        // 📚 ASIGNATURAS
        $assignments = TeacherSubject::with(['subject', 'grade'])
            ->where('teacher_id', $teacher->id)
            ->where('academic_year_id', $year->id)
            ->where('status', true)
            ->get();

        $data = [];

        foreach ($assignments as $assignment) {

            if (!$assignment->subject || !$assignment->grade) continue;

            $subjectId = $assignment->subject->id;

            if (!isset($data[$subjectId])) {
                $data[$subjectId] = [
                    'subject_id' => $subjectId,
                    'subject' => $assignment->subject->name,
                    'grades' => []
                ];
            }

            $data[$subjectId]['grades'][] = [
                'grade_id' => $assignment->grade->id,
                'grade_name' => $assignment->grade->name,
            ];
        }

        $data = array_values($data);

        // 🔥 DIRECTOR DE GRUPO
        $directorGrades = Grade::where('director_id', $teacher->id)->get();

        return view('teacher.dashboard', compact('data', 'directorGrades'));
    }

    /**
     * =========================
     * 🎓 GRADOS POR MATERIA
     * =========================
     */
    public function grades($subjectId)
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            abort(403);
        }

        $year = AcademicYear::where('status', 'activo')->first();

        if (!$year) {
            return back()->with('error', 'No hay año académico activo');
        }

        $assignments = TeacherSubject::with('grade')
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

        return view('teacher.grades', compact('grades', 'subjectId'));
    }

    /**
     * =========================
     * 👨‍🎓 ESTUDIANTES POR GRADO
     * =========================
     */
    public function students($subjectId, $gradeId)
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            abort(403);
        }

        $year = AcademicYear::where('status', 'activo')->first();

        if (!$year) {
            return back()->with('error', 'No hay año académico activo');
        }

      $students = Student::whereHas('enrollments', function ($query) use ($gradeId, $year) {
    $query->where('grade_id', $gradeId)
          ->where('academic_year_id', $year->id);
})
->orderByRaw('LOWER(last_name) ASC')   // 🔥 PRIMERO apellido
->orderByRaw('LOWER(first_name) ASC')  // 🔥 DESPUÉS nombre (desempate)
->get();
        // 🔥 Validar asignación
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
            'teacher_subject_id' => $teacherSubject->id
        ]);
    }

    /**
     * =========================
     * 🔥 NOTA DEL DIRECTOR (BOLETÍN)
     * =========================
     */
    public function storeDisciplinary(Request $request)
{
    $request->validate([
        'grade_id' => 'required|exists:grades,id',
        'notes' => 'required|array'
    ]);

    $teacher = Auth::user()->teacher;

    if (!$teacher) {
        abort(403);
    }

    // 🔥 VALIDAR QUE ES DIRECTOR
    $isDirector = Grade::where('id', $request->grade_id)
        ->where('director_id', $teacher->id)
        ->exists();

    if (!$isDirector) {
        abort(403, 'No eres director de este grado');
    }

    foreach ($request->notes as $studentId => $noteValue) {

        if ($noteValue === null) continue;

        DisciplinaryNote::updateOrCreate(
            [
                'student_id' => $studentId,
                'grade_id' => $request->grade_id,
            ],
            [
                'note' => $noteValue,
                'teacher_id' => $teacher->id
            ]
        );
    }

    return back()->with('success', 'Notas guardadas correctamente');
}
}