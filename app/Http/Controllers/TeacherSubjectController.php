<?php

namespace App\Http\Controllers;

use App\Models\TeacherSubject;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Group;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class TeacherSubjectController extends Controller
{
    /**
     * LISTAR SIN DUPLICAR (AGRUPADO)
     */
    public function index()
    {
        $assignments = TeacherSubject::with([
            'teacher',
            'subject',
            'grade',
            'group',
            'academicYear'
        ])
        ->get()
        ->groupBy(function ($item) {
            return $item->teacher_id . '-' . $item->subject_id . '-' . $item->grade_id . '-' . $item->group_id;
        });

        return view('admin.teacher_subjects.index', compact('assignments'));
    }

    /**
     * FORMULARIO CREAR
     */
    public function create()
    {
        return view('admin.teacher_subjects.create', [
            'teachers' => Teacher::all(),
            'subjects' => Subject::all(),
            'grades' => Grade::all(),
            'groups' => Group::all(),
        ]);
    }

    /**
     * GUARDAR
     */
    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade_id' => 'required|exists:grades,id',
            'group_id' => 'nullable|exists:groups,id',
        ]);

        $activeYear = AcademicYear::where('status', 'activo')->first();

        if (!$activeYear) {
            return back()->with('error', 'No hay un año académico activo');
        }

        $groupId = $request->group_id ?: null;

        $exists = TeacherSubject::where([
            'teacher_id' => $request->teacher_id,
            'subject_id' => $request->subject_id,
            'grade_id' => $request->grade_id,
            'group_id' => $groupId,
            'academic_year_id' => $activeYear->id,
        ])->exists();

        if ($exists) {
            return back()->with('error', 'Ya existe en este año');
        }

        TeacherSubject::create([
            'teacher_id' => $request->teacher_id,
            'subject_id' => $request->subject_id,
            'grade_id' => $request->grade_id,
            'group_id' => $groupId,
            'academic_year_id' => $activeYear->id,
        ]);

        return redirect()->route('admin.teacher-subjects.index')
            ->with('success', 'Asignación creada correctamente');
    }

    /**
     * HISTORIAL DE AÑOS
     */
    public function history($id)
    {
        $assignment = TeacherSubject::findOrFail($id);

        $history = TeacherSubject::where([
            'teacher_id' => $assignment->teacher_id,
            'subject_id' => $assignment->subject_id,
            'grade_id' => $assignment->grade_id,
            'group_id' => $assignment->group_id,
        ])
        ->with('academicYear')
        ->orderByDesc('academic_year_id')
        ->get();

        return view('admin.teacher_subjects.history', compact('history'));
    }

    /**
     * MOSTRAR
     */
    public function show(TeacherSubject $teacherSubject)
    {
        return view('admin.teacher_subjects.show', compact('teacherSubject'));
    }

    /**
     * EDITAR
     */
    public function edit(TeacherSubject $teacherSubject)
    {
        return view('admin.teacher_subjects.edit', [
            'assignment' => $teacherSubject,
            'teachers' => Teacher::all(),
            'subjects' => Subject::all(),
            'grades' => Grade::all(),
            'groups' => Group::all(),
        ]);
    }

    /**
     * ACTUALIZAR SOLO ESTE AÑO
     */
    public function update(Request $request, TeacherSubject $teacherSubject)
    {
        $request->validate([
            'teacher_id' => 'required',
            'subject_id' => 'required',
            'grade_id' => 'required',
            'group_id' => 'nullable',
            'status' => 'required|boolean',
        ]);

        $teacherSubject->update([
            'teacher_id' => $request->teacher_id,
            'subject_id' => $request->subject_id,
            'grade_id' => $request->grade_id,
            'group_id' => $request->group_id ?: null,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.teacher-subjects.index')
            ->with('success', 'Actualizado correctamente');
    }

    /**
     * ELIMINAR
     */
    public function destroy(TeacherSubject $teacherSubject)
    {
        $teacherSubject->delete();

        return back()->with('success', 'Eliminado correctamente');
    }
}