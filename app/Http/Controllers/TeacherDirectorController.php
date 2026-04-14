<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Student;
use App\Models\AcademicYear;

class TeacherDirectorController extends Controller
{
public function index(Request $request)
{
    $teacher = Auth::user()->teacher;

    if (!$teacher) {
        abort(403, 'No autorizado');
    }

    $grades = Grade::where('director_id', $teacher->id)->get();

    $currentYear = AcademicYear::where('status','activo')->first();

    $allStudents = Student::query()
        ->with([
            'enrollments.grade',
            'enrollments.academicYear'
        ])

        ->when($currentYear, function ($q) use ($currentYear) {
            $q->whereHas('enrollments', function ($sub) use ($currentYear) {
                $sub->where('academic_year_id', $currentYear->id);
            });
        })

        ->when($request->name, function ($q) use ($request) {
            $q->where('first_name', 'like', '%' . $request->name . '%');
        })

        ->when($request->last_name, function ($q) use ($request) {
            $q->where('last_name', 'like', '%' . $request->last_name . '%');
        })

        ->when($request->grade_id, function ($q) use ($request, $currentYear) {
            $q->whereHas('enrollments', function ($sub) use ($request, $currentYear) {
                $sub->where('grade_id', $request->grade_id);

                if ($currentYear) {
                    $sub->where('academic_year_id', $currentYear->id);
                }
            });
        })

        ->latest()
        ->paginate(10);

    return view('teacher.director.index', compact('grades', 'allStudents'));
}
 public function students($gradeId)
{
    $teacher = Auth::user()->teacher;

    if (!$teacher) {
        abort(403, 'No autorizado');
    }

    $grade = Grade::where('id', $gradeId)
        ->where('director_id', $teacher->id)
        ->firstOrFail();

    $currentYear = AcademicYear::where('status','activo')->first();

    $students = Student::whereHas('enrollments', function ($q) use ($grade, $currentYear) {
        $q->where('grade_id', $grade->id);

        if ($currentYear) {
            $q->where('academic_year_id', $currentYear->id);
        }
    })
    ->with(['enrollments.grade', 'enrollments.academicYear'])
    ->get();

    return view('teacher.director.students', compact('students', 'grade'));
}
}