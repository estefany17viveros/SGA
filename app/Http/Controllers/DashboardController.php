<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Traer estudiantes con su grado
        $students = Student::with('grade')->get();

        // Filtrar mayores de edad
        $adultStudents = $students->filter(function ($student) {
            return Carbon::parse($student->birth_date)->age >= 18;
        });

        return view('dashboard', [
            'totalStudents' => $students->count(),
            'adultStudentsCount' => $adultStudents->count(),
            'adultStudents' => $adultStudents,
        ]);
    }
}