<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TeacherSubject;
use App\Models\Student;
use App\Models\Score;
use App\Models\AcademicYear;

class ScoreController extends Controller
{
    /**
     * 📊 VER NOTAS (TABLA)
     */
    public function index($id)
    {
        $user = Auth::user();

        // 🔒 Validar profesor
        if (!$user || !$user->teacher) {
            abort(403);
        }

        $teacher = $user->teacher;

        // 🔥 Asignación del profesor
        $assignment = TeacherSubject::where('teacher_id', $teacher->id)
            ->with(['subject', 'grade'])
            ->findOrFail($id);

        // 🔥 Año activo
        $year = AcademicYear::where('status', 'activo')->first();

        if (!$year) {
            return back()->with('error', 'No hay año académico activo');
        }

        // 👨‍🎓 Estudiantes del grado
        $students = Student::whereHas('enrollments', function ($q) use ($assignment, $year) {
            $q->where('grade_id', $assignment->grade_id)
              ->where('academic_year_id', $year->id);
        })->get();

        // 🔥 Traer notas existentes
        $scores = Score::where('teacher_subject_id', $assignment->id)
            ->get()
            ->keyBy('student_id');

        return view('teacher.scores.index', compact('students', 'assignment', 'scores'));
    }

    /**
     * 💾 GUARDAR NOTAS
     */
    public function store(Request $request)
    {
        $request->validate([
            'teacher_subject_id' => 'required|exists:teacher_subjects,id'
        ]);

        foreach ($request->scores as $student_id => $data) {

            Score::updateOrCreate(
                [
                    'student_id' => $student_id,
                    'teacher_subject_id' => $request->teacher_subject_id
                ],
                [
                    'saber' => $data['saber'] ?? null,
                    'hacer' => $data['hacer'] ?? null,
                    'ser' => $data['ser'] ?? null,
                    'comment' => $data['comment'] ?? null
                ]
            );
        }

        return back()->with('success', '✅ Notas guardadas correctamente');
    }
}