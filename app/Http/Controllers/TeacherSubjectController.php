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
     * LISTAR ASIGNACIONES
     */
    public function index()
    {
        $assignments = TeacherSubject::with([
            'teacher',
            'subject',
            'grade',
            'group',
            'academicYear' // 🔥 corregido
        ])->latest()->paginate(10);

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
            'groups' => Group::all(), // sigue siendo opcional
        ]);
    }

    /**
     * GUARDAR
     */
    public function store(Request $request)
    {
        // 🔥 DEBUG REAL
    // dd($request->all());

    $request->validate([
        'teacher_id' => 'required|exists:teachers,id',
        'subject_id' => 'required|exists:subjects,id',
        'grade_id' => 'required|exists:grades,id',
        'group_id' => 'nullable|exists:groups,id',
    ]);

        // 🔥 Año activo automático
        $activeYear = AcademicYear::where('status', 'activo')->first();
        if (!$activeYear) {
            return back()->with('error', 'No hay un año académico activo');
        }

        // 🔒 Normalizar group_id (IMPORTANTE)
        $groupId = $request->group_id ?: null;

        // 🔒 Evitar duplicados
        $exists = TeacherSubject::where([
            'teacher_id' => $request->teacher_id,
            'subject_id' => $request->subject_id,
            'grade_id' => $request->grade_id,
            'group_id' => $groupId,
            'academic_year_id' => $activeYear->id,
        ])->exists();

        if ($exists) {
            return back()->with('error', 'Esta asignación ya existe en el año activo');
        }

        // ✅ Crear
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
     * MOSTRAR
     */
    public function show(TeacherSubject $teacherSubject)
    {
        $assignment = $teacherSubject->load([
            'teacher',
            'subject',
            'grade',
            'group',
            'academicYear'
        ]);

        return view('admin.teacher_subjects.show', compact('assignment'));
    }

    /**
     * FORM EDITAR
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
     * ACTUALIZAR
     */
    public function update(Request $request, TeacherSubject $teacherSubject)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade_id' => 'required|exists:grades,id',
            'group_id' => 'nullable|exists:groups,id',
            'status' => 'required|boolean',
        ]);

        $groupId = $request->group_id ?: null;

        $teacherSubject->update([
            'teacher_id' => $request->teacher_id,
            'subject_id' => $request->subject_id,
            'grade_id' => $request->grade_id,
            'group_id' => $groupId,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.teacher-subjects.index')
            ->with('success', 'Asignación actualizada correctamente');
    }

    /**
     * ELIMINAR
     */
    public function destroy(TeacherSubject $teacherSubject)
    {
        $teacherSubject->delete();

        return back()->with('success', 'Asignación eliminada');
    }

}