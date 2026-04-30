<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DimensionComment;
use App\Models\TeacherSubject;
use App\Models\AcademicYear;
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

        // 🔥 AÑOS ACADÉMICOS
        $years = AcademicYear::orderBy('year', 'desc')->get();

        // 🔥 Año seleccionado
        $yearId = $request->academic_year_id
            ?? AcademicYear::where('status', 'activo')->value('id');

        // 🔥 Materias del profesor (sin duplicados)
        $assignments = TeacherSubject::where('teacher_id', $teacher->id)
            ->with(['subject', 'grade'])
            ->get()
            ->unique(fn ($item) => $item->subject_id . '-' . $item->grade_id)
            ->values();

        // 🔥 Periodos del año seleccionado
        $periods = Period::where('academic_year_id', $yearId)
            ->orderBy('id', 'asc')
            ->get();

        // 🔥 Periodo seleccionado (OBJETO REAL)
        $selectedPeriod = null;
        if ($request->period_id) {
            $selectedPeriod = Period::find($request->period_id);
        }

        $assignment = null;
        $comments = collect();

        // 🔥 SOLO SI TODO ESTÁ SELECCIONADO
        if ($request->teacher_subject_id && $request->period_id) {

            $assignment = TeacherSubject::where('teacher_id', $teacher->id)
                ->where('id', $request->teacher_subject_id)
                ->with(['subject', 'grade'])
                ->firstOrFail();

            $comments = DimensionComment::where('teacher_subject_id', $assignment->id)
                ->where('period_id', $request->period_id)
                ->where('academic_year_id', $yearId)
                ->where('grade_id', $assignment->grade_id)
                ->get()
                ->keyBy('dimension');
        }

        return view('teacher.dimension_comments.index', compact(
            'assignments',
            'assignment',
            'comments',
            'periods',
            'years',
            'yearId',
            'selectedPeriod'
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
            'period_id' => 'required|exists:periods,id',
            'academic_year_id' => 'required|exists:academic_years,id'
        ]);

        $user = Auth::user();

        if (!$user || !$user->teacher) {
            abort(403);
        }

        $teacher = $user->teacher;

        $assignment = TeacherSubject::where('teacher_id', $teacher->id)
            ->where('id', $request->teacher_subject_id)
            ->firstOrFail();

        foreach (['saber', 'hacer', 'ser'] as $dimension) {

            DimensionComment::updateOrCreate(
                [
                    'teacher_subject_id' => $assignment->id,
                    'grade_id' => $request->grade_id,
                    'period_id' => $request->period_id,
                    'academic_year_id' => $request->academic_year_id,
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