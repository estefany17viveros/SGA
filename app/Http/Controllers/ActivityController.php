<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Grade;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    /**
     * 📊 LISTAR ACTIVIDADES + ESTUDIANTES POR GRADO
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user->teacher) {
            abort(403, 'No tienes asignado un profesor');
        }

        // 🔽 TODOS LOS GRADOS
        $grades = Grade::all();

        $students = collect();
        $activities = collect();

        if ($request->grade_id) {

            // 🔥 1. GRUPOS DEL GRADO
            $groups = Group::where('grade_id', $request->grade_id)->pluck('id');

            // 🔥 2. ESTUDIANTES DEL GRADO
            $students = Student::whereIn('group_id', $groups)->get();

            // 🔥 3. ACTIVIDADES DEL PROFESOR EN ESE GRADO
            $activities = Activity::where('teacher_id', $user->teacher->id)
                ->whereIn('group_id', $groups)
                ->with('scores') // 🔥 evita consultas en la vista
                ->get()
                ->groupBy('type'); // saber, hacer, ser
        }

        return view('teacher.activities.index', compact(
            'grades',
            'students',
            'activities'
        ));
    }

    /**
     * ➕ CREAR ACTIVIDAD
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'group_id' => 'required|exists:groups,id',
            'period_id' => 'required|exists:periods,id',
            'type' => 'required|in:saber,hacer,ser',
            'description' => 'required|string|max:255',
            'percentage' => 'required|numeric|min:1|max:100',
        ]);

        $teacherId = Auth::user()->teacher->id;

        // 🔥 VALIDAR % NO SUPERE 100
        $total = Activity::where([
            'teacher_id' => $teacherId,
            'subject_id' => $request->subject_id,
            'group_id' => $request->group_id,
            'period_id' => $request->period_id,
            'type' => $request->type
        ])->sum('percentage');

        if (($total + $request->percentage) > 100) {
            return back()->with('error', 'Los porcentajes no pueden superar el 100%');
        }

        Activity::create([
            'teacher_id' => $teacherId,
            ...$request->all()
        ]);

        return redirect()->route('teacher.activities.index')
            ->with('success', 'Actividad creada correctamente');
    }

    /**
     * 📄 MOSTRAR ACTIVIDAD
     */
    public function show($id)
    {
        $activity = Activity::with('scores.student')->findOrFail($id);

        return view('teacher.activities.show', compact('activity'));
    }

    /**
     * ✏️ ACTUALIZAR ACTIVIDAD
     */
    public function update(Request $request, $id)
    {
        $activity = Activity::findOrFail($id);

        $request->validate([
            'description' => 'required|string|max:255',
            'percentage' => 'required|numeric|min:1|max:100',
        ]);

        // 🔥 VALIDAR % SIN CONTARSE A SÍ MISMA
        $total = Activity::where([
            'teacher_id' => $activity->teacher_id,
            'subject_id' => $activity->subject_id,
            'group_id' => $activity->group_id,
            'period_id' => $activity->period_id,
            'type' => $activity->type
        ])
        ->where('id', '!=', $id)
        ->sum('percentage');

        if (($total + $request->percentage) > 100) {
            return back()->with('error', 'Los porcentajes no pueden superar el 100%');
        }

        $activity->update($request->only('description', 'percentage'));

        return redirect()->route('teacher.activities.index')
            ->with('success', 'Actividad actualizada');
    }

    /**
     * 🗑️ ELIMINAR ACTIVIDAD
     */
    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);

        $count = Activity::where([
            'teacher_id' => $activity->teacher_id,
            'subject_id' => $activity->subject_id,
            'group_id' => $activity->group_id,
            'period_id' => $activity->period_id,
            'type' => $activity->type
        ])->count();

        if ($count <= 3) {
            return back()->with('error', 'Debe haber mínimo 3 actividades');
        }

        $activity->delete();

        return redirect()->route('teacher.activities.index')
            ->with('success', 'Actividad eliminada');
    }
}