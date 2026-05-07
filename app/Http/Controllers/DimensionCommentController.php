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
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->teacher) {
            abort(403, 'No autorizado');
        }

        $teacher = $user->teacher;

        $years = AcademicYear::orderBy('year', 'desc')->get();

        $yearId = $request->academic_year_id
            ?? AcademicYear::where('status', 'activo')->value('id');

        $assignments = TeacherSubject::where('teacher_id', $teacher->id)
            ->where('status', 1)
            ->with(['subject', 'grade'])
            ->get();

        // 🔥 DISCIPLINA VIRTUAL
        $assignments->push((object)[
            'id' => 'discipline_all',
            'subject' => (object)['name' => 'Disciplina'],
            'grade' => (object)['name' => 'General']
        ]);

        $periods = Period::where('academic_year_id', $yearId)
            ->orderBy('id')
            ->get();

        $assignment = null;
        $comments = collect();
        $isDiscipline = false;

        if ($request->teacher_subject_id && $request->period_id) {

            $selectedId = trim($request->teacher_subject_id);

            // =========================
            // DISCIPLINA
            // =========================
            if ($selectedId === 'discipline_all') {

                $isDiscipline = true;

                $assignment = (object)[
                    'id' => 'discipline_all'
                ];

                $comments = DimensionComment::whereNull('teacher_subject_id')
                    ->where('dimension', 'disciplina')
                    ->where('period_id', $request->period_id)
                    ->where('academic_year_id', $yearId)
                    ->get()
                    ->keyBy('dimension');
            }

            // =========================
            // MATERIAS NORMALES
            // =========================
            else {

                $assignment = TeacherSubject::where('teacher_id', $teacher->id)
                    ->where('id', $selectedId)
                    ->with(['subject', 'grade'])
                    ->first();

                if ($assignment) {

                    $comments = DimensionComment::where('teacher_subject_id', $assignment->id)
                        ->where('period_id', $request->period_id)
                        ->where('academic_year_id', $yearId)
                        ->get()
                        ->keyBy('dimension');
                }
            }
        }

        return view('teacher.dimension_comments.index', compact(
            'assignments',
            'assignment',
            'comments',
            'periods',
            'years',
            'yearId',
            'isDiscipline'
        ));
    }

    public function store(Request $request)
    {
        $teacher = Auth::user()->teacher;
        $selectedId = trim($request->teacher_subject_id);

        // =========================
        // VALIDACIÓN FLEXIBLE
        // =========================
        $request->validate([
            'teacher_subject_id' => 'required',
            'period_id' => 'required|exists:periods,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'grade_id' => 'nullable'
        ]);

        // =========================
        // DISCIPLINA
        // =========================
        if ($selectedId === 'discipline_all') {

            DimensionComment::updateOrCreate(
                [
                    'teacher_subject_id' => null,
                    'grade_id' => null,
                    'period_id' => $request->period_id,
                    'academic_year_id' => $request->academic_year_id,
                    'dimension' => 'disciplina'
                ],
                [
                    'comment' => $request->input('comments.disciplina', '')
                ]
            );

            return back()->with('success', 'Disciplina guardada correctamente');
        }

        // =========================
        // MATERIA NORMAL
        // =========================

        $assignment = TeacherSubject::where('teacher_id', $teacher->id)
            ->where('id', $selectedId)
            ->first();

        if (!$assignment) {
            return back()->with('error', 'Asignación inválida');
        }

        foreach (['saber', 'hacer', 'ser'] as $dimension) {

            DimensionComment::updateOrCreate(
                [
                    'teacher_subject_id' => $assignment->id,
                    'grade_id' => $assignment->grade_id,
                    'period_id' => $request->period_id,
                    'academic_year_id' => $request->academic_year_id,
                    'dimension' => $dimension
                ],
                [
                    'comment' => $request->input("comments.$dimension", '')
                ]
            );
        }

        return back()->with('success', 'Guardado correctamente');
    }
}