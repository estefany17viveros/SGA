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
            'subject' => (object)[
                'name' => 'Disciplina'
            ],
            'grade' => (object)[
                'name' => 'General'
            ]
        ]);

        $periods = Period::where('academic_year_id', $yearId)
            ->orderBy('id')
            ->get();

        $assignment = null;

        $comments = collect();

        $isDiscipline = false;

        if ($request->teacher_subject_id && $request->period_id) {

            $selectedId = trim($request->teacher_subject_id);

            /*
            |--------------------------------------------------------------------------
            | DISCIPLINA
            |--------------------------------------------------------------------------
            */

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

            /*
            |--------------------------------------------------------------------------
            | MATERIAS NORMALES
            |--------------------------------------------------------------------------
            */

            else {

                $assignment = TeacherSubject::where('teacher_id', $teacher->id)
                    ->where('id', $selectedId)
                    ->with(['subject', 'grade'])
                    ->first();

                if ($assignment) {

                    $comments = DimensionComment::where(
                            'teacher_subject_id',
                            $assignment->id
                        )
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
        try {

            $teacher = Auth::user()->teacher;

            if (!$teacher) {

                return back()->with(
                    'error',
                    'No tienes permisos para realizar esta acción.'
                );
            }

            $selectedId = trim($request->teacher_subject_id);

            /*
            |--------------------------------------------------------------------------
            | VALIDACIONES GENERALES
            |--------------------------------------------------------------------------
            */

            $request->validate([

                'teacher_subject_id' => 'required',

                'period_id' => 'required|exists:periods,id',

                'academic_year_id' => 'required|exists:academic_years,id'

            ], [

                'teacher_subject_id.required' =>
                    'Debe seleccionar una materia.',

                'period_id.required' =>
                    'Debe seleccionar un periodo.',

                'period_id.exists' =>
                    'El periodo seleccionado no es válido.',

                'academic_year_id.required' =>
                    'Debe seleccionar un año académico.',

                'academic_year_id.exists' =>
                    'El año académico seleccionado no es válido.'
            ]);

            /*
            |--------------------------------------------------------------------------
            | DISCIPLINA
            |--------------------------------------------------------------------------
            */

            if ($selectedId === 'discipline_all') {

                $disciplina = trim(
                    $request->input('comments.disciplina', '')
                );

                if ($disciplina === '') {

                    return back()
                        ->withInput()
                        ->with(
                            'error',
                            'Debe escribir el comentario de disciplina.'
                        );
                }

                DimensionComment::updateOrCreate(

                    [
                        'teacher_subject_id' => null,
                        'grade_id' => null,
                        'period_id' => $request->period_id,
                        'academic_year_id' => $request->academic_year_id,
                        'dimension' => 'disciplina'
                    ],

                    [
                        'comment' => $disciplina
                    ]
                );

                return back()->with(
                    'success',
                    'Comentario de disciplina guardado correctamente.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | VALIDAR ASIGNACIÓN
            |--------------------------------------------------------------------------
            */

            $assignment = TeacherSubject::where(
                    'teacher_id',
                    $teacher->id
                )
                ->where('id', $selectedId)
                ->first();

            if (!$assignment) {

                return back()->with(
                    'error',
                    'La asignación seleccionada no es válida.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | VALIDAR DIMENSIONES
            |--------------------------------------------------------------------------
            */

            foreach (['saber', 'hacer', 'ser'] as $dimension) {

                $comment = trim(
                    $request->input("comments.$dimension", '')
                );

                if ($comment === '') {

                    return back()
                        ->withInput()
                        ->with(
                            'error',
                            'Debe completar todos los comentarios antes de guardar.'
                        );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | GUARDAR
            |--------------------------------------------------------------------------
            */

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
                        'comment' => trim(
                            $request->input("comments.$dimension")
                        )
                    ]
                );
            }

            return back()->with(
                'success',
                'Comentarios guardados correctamente.'
            );

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Ocurrió un error inesperado al guardar los comentarios.'
                );
        }
    }
}