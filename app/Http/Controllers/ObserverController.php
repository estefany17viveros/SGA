<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Observer;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ObserverController extends Controller
{

    // 🔹 CREAR OBSERVACIÓN
    public function store(Request $request, $studentId)
    {
        $request->validate([
            'observation' => 'required|string',
            'file' => 'nullable|mimes:pdf|max:2048'
        ]);

        $student = Student::findOrFail($studentId);
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            abort(403, 'No autorizado');
        }

        // 🔥 Validar que sea director del grado
        $enrollment = $student->enrollments()->latest()->first();

        if (!$enrollment || $enrollment->grade->director_id != $teacher->id) {
            abort(403, 'No tienes permiso para este estudiante');
        }

        $data = [
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'observation' => $request->observation
        ];

        // 📄 Guardar PDF
        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('observers', 'public');
        }

        Observer::create($data);

        return back()->with('success', '✅ Observación creada correctamente');
    }

    // 🔹 EDITAR (vista)
    public function edit(Observer $observer)
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher || $observer->teacher_id != $teacher->id) {
            abort(403, 'No autorizado');
        }

        return view('teacher.observer.edit', compact('observer'));
    }

    // 🔹 ACTUALIZAR
    public function update(Request $request, Observer $observer)
    {
        $request->validate([
            'observation' => 'required|string',
            'file' => 'nullable|mimes:pdf|max:2048'
        ]);

        $teacher = Auth::user()->teacher;

        if (!$teacher || $observer->teacher_id != $teacher->id) {
            abort(403, 'No autorizado');
        }

        $observer->observation = $request->observation;

        // 📄 Reemplazar archivo si sube otro
        if ($request->hasFile('file')) {

            // 🔥 borrar archivo anterior
            if ($observer->file && Storage::disk('public')->exists($observer->file)) {
                Storage::disk('public')->delete($observer->file);
            }

            $observer->file = $request->file('file')->store('observers', 'public');
        }

        $observer->save();

        return back()->with('success', '✅ Observación actualizada');
    }

    // 🔹 ELIMINAR
    public function destroy(Observer $observer)
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher || $observer->teacher_id != $teacher->id) {
            abort(403, 'No autorizado');
        }

        // 🔥 eliminar archivo si existe
        if ($observer->file && Storage::disk('public')->exists($observer->file)) {
            Storage::disk('public')->delete($observer->file);
        }

        $observer->delete();

        return back()->with('success', '🗑 Observación eliminada');
    }
}