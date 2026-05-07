<?php

namespace App\Http\Controllers;

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

        $user = Auth::user();
        $teacher = $user->teacher;

        if (!$teacher) {
            abort(403, 'No autorizado');
        }

        $student = Student::findOrFail($studentId);
        $enrollment = $student->enrollments()->latest()->first();

        // 🔥 SOLO DIRECTOR
        if (!$enrollment || $enrollment->grade->director_id != $teacher->id) {
            abort(403, 'No tienes permiso para este estudiante');
        }

        $data = [
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'observation' => $request->observation
        ];

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('observers', 'public');
        }

        Observer::create($data);

        return back()->with('success', '✅ Observación creada correctamente');
    }

    // 🔹 EDITAR (VISTA)
    public function edit(Observer $observer)
    {
        $user = Auth::user();

        // 🔥 ADMIN VE TODO
        if ($user->role === 'admin') {
            return view('teacher.observer.edit', compact('observer'));
        }

        $teacher = $user->teacher;

        if (!$teacher) {
            abort(403);
        }

        // 🔥 SOLO CREADOR O DIRECTOR
        $student = $observer->student;
        $enrollment = $student->enrollments()->latest()->first();

        if (
            $observer->teacher_id != $teacher->id &&
            (!$enrollment || $enrollment->grade->director_id != $teacher->id)
        ) {
            abort(403);
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

        $user = Auth::user();

        // 🔥 ADMIN PUEDE TODO
        if ($user->role !== 'admin') {

            $teacher = $user->teacher;

            if (!$teacher) {
                abort(403);
            }

            $student = $observer->student;
            $enrollment = $student->enrollments()->latest()->first();

            // 🔥 CREADOR O DIRECTOR
            if (
                $observer->teacher_id != $teacher->id &&
                (!$enrollment || $enrollment->grade->director_id != $teacher->id)
            ) {
                abort(403);
            }
        }

        $observer->observation = $request->observation;

        if ($request->hasFile('file')) {

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
        $user = Auth::user();

        // 🔥 ADMIN PUEDE TODO
        if ($user->role !== 'admin') {

            $teacher = $user->teacher;

            if (!$teacher) {
                abort(403);
            }

            $student = $observer->student;
            $enrollment = $student->enrollments()->latest()->first();

            // 🔥 CREADOR O DIRECTOR
            if (
                $observer->teacher_id != $teacher->id &&
                (!$enrollment || $enrollment->grade->director_id != $teacher->id)
            ) {
                abort(403);
            }
        }

        if ($observer->file && Storage::disk('public')->exists($observer->file)) {
            Storage::disk('public')->delete($observer->file);
        }

        $observer->delete();

        return back()->with('success', '🗑 Observación eliminada');
    }

    // 🔹 LISTAR
    public function index($studentId)
    {
        $user = Auth::user();
        $student = Student::findOrFail($studentId);

        // 🔥 ADMIN VE TODO
        if ($user->role === 'admin') {
            $observers = Observer::where('student_id', $student->id)->get();
            return view('observer.index', compact('observers', 'student'));
        }

        $teacher = $user->teacher;

        if (!$teacher) {
            abort(403);
        }

        $enrollment = $student->enrollments()->latest()->first();

        // 🔥 SOLO DIRECTOR
        if (!$enrollment || $enrollment->grade->director_id != $teacher->id) {
            abort(403);
        }

        $observers = Observer::where('student_id', $student->id)->get();

        return view('observer.index', compact('observers', 'student'));
    }
}