<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Grade;

class GroupController extends Controller
{
    /**
     * Listar grupos de un grado
     */
    public function index(Grade $grade)
{

    $groups = $grade->groups()
        ->withCount('enrollments')
        ->orderBy('name')
        ->get();

    return view('admin.groups.index', compact('grade', 'groups'));
}
    /**
     * Formulario crear grupo
     */
    public function create($gradeId)
    {
        $grade = Grade::findOrFail($gradeId);
        return view('admin.groups.create', compact('grade'));
    }

    /**
     * Guardar grupo
     */
    public function store(Request $request, $gradeId)
    {
        $grade = Grade::findOrFail($gradeId);

        $request->validate([
            'name' => 'required|string|max:50|unique:groups,name,NULL,id,grade_id,' . $grade->id,
            'capacity' => 'required|integer|min:0',
        ]);

        Group::create([
            'name' => strtoupper($request->name),
            'capacity' => $request->capacity,
            'status' => 'activo',
            'grade_id' => $grade->id,
        ]);

        return redirect()
            ->route('admin.grades.groups.index', $grade->id)
            ->with('success', 'Grupo creado correctamente.');
    }

    /**
     * Editar grupo
     */
  
public function edit(Grade $grade, Group $group)
{
    // Ya no necesitas buscar el grupo manualmente, Laravel lo hace por ti (Route Model Binding)
    return view('admin.groups.edit', compact('grade', 'group'));
}

    /**
     * Actualizar grupo
     */
    public function update(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:50|unique:groups,name,' 
                        . $group->id 
                        . ',id,grade_id,' 
                        . $group->grade_id,
            'capacity' => 'required|integer|min:0',
            'status' => 'required|in:activo,cerrado',
        ]);

        $group->update([
            'name' => strtoupper($request->name),
            'capacity' => $request->capacity,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.grades.groups.index', $group->grade_id)
            ->with('success', 'Grupo actualizado correctamente.');
    }
    public function show(Grade $grade, Group $group)
{
    // Validación extra de seguridad (muy importante)
    if ($group->grade_id !== $grade->id) {
        abort(404);
    }

    $group->loadCount('enrollments');
  
    return view('admin.groups.show', compact('grade', 'group'));
}

    /**
     * Eliminar grupo
     */
   
public function destroy(Grade $grade, Group $group)
{
    if ($group->enrollments()->exists()) {
        return back()->with('error', 'No se puede eliminar un grupo con matrículas.');
    }

    $group->delete();

    return redirect()
        ->route('admin.grades.groups.index', $grade->id)
        ->with('success', 'Grupo eliminado correctamente.');
}
}