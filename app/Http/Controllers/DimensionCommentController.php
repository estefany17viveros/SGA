<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DimensionComment;
use App\Models\TeacherSubject;
use App\Models\Period;

class DimensionCommentController extends Controller
{
    /**
     * 📊 MOSTRAR FORMULARIO
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->teacher) {
            abort(403, 'No autorizado');
        }

        $teacher = $user->teacher;

        // 🔥 Materias asignadas al profesor
        $assignments = TeacherSubject::where('teacher_id', $teacher->id)
            ->with(['subject', 'grade'])
            ->get();

        // 🔥 Periodos
        $periods = Period::all();

        $assignment = null;
        $comments = collect();

        // 🔥 Si selecciona asignación + periodo
        if ($request->teacher_subject_id && $request->period_id) {

            $assignment = TeacherSubject::where('teacher_id', $teacher->id)
                ->where('id', $request->teacher_subject_id)
                ->with(['subject', 'grade'])
                ->firstOrFail();

            $comments = DimensionComment::where('teacher_subject_id', $assignment->id)
                ->where('period_id', $request->period_id)
                ->get()
                ->keyBy('dimension');
        }

        return view('teacher.dimension_comments.index', compact(
            'assignments',
            'assignment',
            'comments',
            'periods'
        ));
    }

    /**
     * 💾 GUARDAR / ACTUALIZAR
     */
    public function store(Request $request)
    {
        $request->validate([
            'teacher_subject_id' => 'required|exists:teacher_subjects,id',
            'grade_id' => 'required|exists:grades,id',
            'period_id' => 'required|exists:periods,id'
        ]);

        $user = Auth::user();

        if (!$user || !$user->teacher) {
            abort(403);
        }

        $teacher = $user->teacher;

        // 🔥 Validar que la materia pertenezca al profesor
        $assignment = TeacherSubject::where('teacher_id', $teacher->id)
            ->where('id', $request->teacher_subject_id)
            ->firstOrFail();

        foreach (['saber', 'hacer', 'ser'] as $dimension) {

            DimensionComment::updateOrCreate(
                [
                    'teacher_subject_id' => $assignment->id,
                    'grade_id' => $request->grade_id,
                    'period_id' => $request->period_id,
                    'dimension' => $dimension
                ],
                [
                    'comment' => $request->input("comments.$dimension", '')
                ]
            );
        }

        return back()->with('success', '✅ Comentarios guardados correctamente');
    }
}