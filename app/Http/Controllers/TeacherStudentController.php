<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class TeacherStudentController extends Controller
{
    public function show($id)
    {
        $student = Student::with([
            'guardians',
            'enrollments.grade',
            'enrollments.academicYear'
        ])->findOrFail($id);

        $teacher = auth()->user()->teacher;

        $isDirector = false;

        // 🔥 Mejor práctica: obtener matrícula activa (no latest sin control)
        $enrollment = $student->enrollments()
            ->with('grade')
            ->latest()
            ->first();

        if ($enrollment && $enrollment->grade) {
            $isDirector = $enrollment->grade->director_id == $teacher->id;
        }

        return view('teacher.students.show', compact('student', 'isDirector'));
    }

    public function updateObserver(Request $request, $id)
    {
        $request->validate([
            'observations' => 'required|string',
            'certificate_file' => 'nullable|mimes:pdf|max:2048'
        ]);

        $student = Student::findOrFail($id);

        $student->observations = $request->observations;

        if ($request->hasFile('certificate_file')) {
            $student->certificate_file = $request->file('certificate_file')
                ->store('students', 'public');
        }

        $student->save();

        return back()->with('success', 'Observador actualizado correctamente');
    }
}