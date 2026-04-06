<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * 📋 Listar materias
     */
    public function index(Request $request)
    {
        $subjects = Subject::when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('admin.subjects.index', compact('subjects'));
    }

    /**
     * ➕ Formulario crear
     */
    public function create()
    {
        return view('admin.subjects.create');
    }

    /**
     * 💾 Guardar materia
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Subject::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 'active'
        ]);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Materia creada correctamente');
    }

    /**
     * 👁️ Ver detalle (opcional pero profesional)
     */
    public function show(Subject $subject)
    {
        return view('admin.subjects.show', compact('subject'));
    }

    /**
     * ✏️ Formulario editar
     */
    public function edit(Subject $subject)
    {
        return view('admin.subjects.edit', compact('subject'));
    }

    /**
     * 🔄 Actualizar materia
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        $subject->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Materia actualizada correctamente');
    }

    /**
     * 🗑️ Eliminar materia
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return back()->with('success', 'Materia eliminada correctamente');
    }
}