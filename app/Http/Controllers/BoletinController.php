<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Student;
use App\Models\Score;
use App\Models\Period;

class BoletinController extends Controller
{
    public function show($studentId, $periodId)
{
    $student = Student::with('enrollments.grade')->findOrFail($studentId);
    $period = Period::findOrFail($periodId);

    // ✅ Notas del estudiante en este periodo
    $scores = Score::with(['teacherSubject.subject', 'teacherSubject.teacher.user'])
        ->where('period_id', $periodId)
        ->get();

    // 🔥 RANKING DEL GRADO
    $ranking = $scores->groupBy('student_id')->map(function ($items) {
        return [
            'student_id' => $items->first()->student_id,
            'total' => $items->avg('total')
        ];
    })->sortByDesc('total')->values();

    // 🔥 CALCULAR PUESTO
    $puesto = null;
    foreach ($ranking as $index => $item) {
        if ($item['student_id'] == $studentId) {
            $puesto = $index + 1;
            break;
        }
    }

    // 🔥 FILTRAR SOLO LAS NOTAS DEL ESTUDIANTE
    $scoresStudent = $scores->where('student_id', $studentId);

    // 🔥 HISTORIAL (RH)
    $allScores = Score::with('period')
        ->where('student_id', $studentId)
        ->get()
        ->groupBy('teacher_subject_id');

    // 🔥 SACAR GRADO
    $grade = optional($student->enrollments->first())->grade->name ?? 'N/A';

    return view('boletin.show', [
        'student' => $student,
        'scores' => $scoresStudent,
        'period' => $period,
        'puesto' => $puesto,
        'allScores' => $allScores,
        'grade' => $grade
    ]);
}

public function pdf($studentId, $periodId)
{
    $student = Student::with('enrollments.grade')->findOrFail($studentId);
    $period = Period::findOrFail($periodId);

    $scores = Score::with(['teacherSubject.subject', 'teacherSubject.teacher.user'])
        ->where('student_id', $studentId)
        ->where('period_id', $periodId)
        ->get();

    $allScores = Score::with('period')
        ->where('student_id', $studentId)
        ->get()
        ->groupBy('teacher_subject_id');

    $grade = optional($student->enrollments->first())->grade->name ?? 'N/A';

    $pdf = Pdf::loadView('boletin.show', compact(
        'student','scores','period','allScores','grade'
    ));

    return $pdf->download('boletin.pdf');
}
}