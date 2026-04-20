<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Student;
use App\Models\Score;
use App\Models\Period;
use App\Models\Enrollment;
use App\Models\AcademicYear;
use App\Models\Grade;
use App\Models\DimensionComment;

class BoletinController extends Controller
{
    public function index()
    {
        $grades = Grade::orderBy('level')->get();
        return view('admin.boletin.index', compact('grades'));
    }

    public function grade($id)
    {
        $year = AcademicYear::where('status', 'activo')->first();

        if (!$year) {
            return back()->with('error', 'No hay año activo');
        }

        $enrollments = Enrollment::with('student')
            ->where('grade_id', $id)
            ->where('academic_year_id', $year->id)
            ->get();

        $periods = Period::where('academic_year_id', $year->id)->get();

        return view('admin.boletin.grade', compact('enrollments', 'periods'))
            ->with('gradeId', $id);
    }

    // ══════════════════════════════════════
    // BOLETÍN INDIVIDUAL — vista web
    // ══════════════════════════════════════
    public function show($studentId, $periodId)
    {
        $year = AcademicYear::where('status', 'activo')->first();
        if (!$year) abort(404, 'No hay año activo');

        $student = Student::findOrFail($studentId);
        $period  = Period::findOrFail($periodId);

        $enrollment = Enrollment::with('grade')
            ->where('student_id', $studentId)
            ->where('academic_year_id', $year->id)
            ->firstOrFail();

        $scores = Score::with([
                'teacherSubject.subject',
                'teacherSubject.teacher.user'
            ])
            ->where('student_id', $studentId)
            ->where('period_id', $periodId)
            ->get();

        // Historial de todos los periodos agrupado por materia
        $allScores = Score::with('period')
            ->where('student_id', $studentId)
            ->get()
            ->groupBy('teacher_subject_id');

        // Puesto en clase
        $scoresGrado = Score::where('period_id', $periodId)
            ->whereIn('student_id',
                Enrollment::where('grade_id', $enrollment->grade_id)
                    ->where('academic_year_id', $year->id)
                    ->pluck('student_id')
            )
            ->get()
            ->groupBy('student_id')
            ->map(fn($items) => round($items->avg('total'), 2))
            ->sortDesc()
            ->keys()
            ->toArray();

        $puesto = array_search($studentId, $scoresGrado);
        $puesto = ($puesto !== false) ? $puesto + 1 : '—';

        // Logo en base64 para PDF y web
        $logoPath   = public_path('images/logo-itaf.jpg');
        $logoBase64 = file_exists($logoPath)
            ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath))
            : null;

        return view('admin.boletin.show', compact(
            'student', 'period', 'scores', 'allScores',
            'puesto', 'yearLectivo', 'logoBase64'
        ))->with([
            'grade'       => optional($enrollment->grade)->name ?? 'N/A',
            'yearLectivo' => $year->year,
        ]);
    }

    // ══════════════════════════════════════
    // BOLETÍN INDIVIDUAL — descarga PDF
    // ══════════════════════════════════════
    public function pdf($studentId, $periodId)
    {
        $year = AcademicYear::where('status', 'activo')->first();
        if (!$year) abort(404, 'No hay año activo');

        $student = Student::findOrFail($studentId);
        $period  = Period::findOrFail($periodId);

        $enrollment = Enrollment::with('grade')
            ->where('student_id', $studentId)
            ->where('academic_year_id', $year->id)
            ->firstOrFail();

        $scores = Score::with([
                'teacherSubject.subject',
                'teacherSubject.teacher.user'
            ])
            ->where('student_id', $studentId)
            ->where('period_id', $periodId)
            ->get();

        $allScores = Score::with('period')
            ->where('student_id', $studentId)
            ->get()
            ->groupBy('teacher_subject_id');

        $scoresGrado = Score::where('period_id', $periodId)
            ->whereIn('student_id',
                Enrollment::where('grade_id', $enrollment->grade_id)
                    ->where('academic_year_id', $year->id)
                    ->pluck('student_id')
            )
            ->get()
            ->groupBy('student_id')
            ->map(fn($items) => round($items->avg('total'), 2))
            ->sortDesc()
            ->keys()
            ->toArray();

        $puesto = array_search($studentId, $scoresGrado);
        $puesto = ($puesto !== false) ? $puesto + 1 : '—';

        // ✅ Logo en base64 — OBLIGATORIO para DomPDF (no soporta asset())
        $logoPath   = public_path('images/logo-itaf.jpg');
        $logoBase64 = file_exists($logoPath)
            ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath))
            : null;

        $pdf = Pdf::loadView('admin.boletin.show', [
                'student'     => $student,
                'period'      => $period,
                'scores'      => $scores,
                'allScores'   => $allScores,
                'puesto'      => $puesto,
                'grade'       => optional($enrollment->grade)->name ?? 'N/A',
                'yearLectivo' => $year->year,
                'logoBase64'  => $logoBase64,
                'isPdf'       => true,
            ])
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'dpi'                => 150,
                'isRemoteEnabled'    => false,
                'isHtml5ParserEnabled' => true,
                'defaultFont'        => 'DejaVu Sans',
            ]);

        $nombre = 'boletin_' . $student->identification_number . '_p' . $periodId . '.pdf';
        return $pdf->download($nombre);
    }

    // ══════════════════════════════════════
    // PDF MASIVO — todos los estudiantes del grado
    // ══════════════════════════════════════
    public function pdfMasivo($gradeId, $periodId)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $year = AcademicYear::where('status', 'activo')->first();
        if (!$year) abort(404, 'No hay año activo');

        $period = Period::findOrFail($periodId);

        $enrollments = Enrollment::with('student', 'grade')
            ->where('grade_id', $gradeId)
            ->where('academic_year_id', $year->id)
            ->get();

        if ($enrollments->isEmpty()) abort(404, 'No hay estudiantes');

        $studentIds = $enrollments->pluck('student_id');

        $scoresAll = Score::with([
                'teacherSubject.subject',
                'teacherSubject.teacher.user'
            ])
            ->where('period_id', $periodId)
            ->whereIn('student_id', $studentIds)
            ->get();

        $allScoresAll = Score::with('period')
            ->whereIn('student_id', $studentIds)
            ->get()
            ->groupBy('student_id');

        $ranking = $scoresAll->groupBy('student_id')
            ->map(fn($items, $id) => [
                'student_id' => $id,
                'promedio'   => round($items->avg('total'), 2),
            ])
            ->sortByDesc('promedio')
            ->values();

        $scoresGrouped = $scoresAll->groupBy('student_id');

        $commentsAll = DimensionComment::where('period_id', $periodId)
            ->whereIn('teacher_subject_id', $scoresAll->pluck('teacher_subject_id'))
            ->get()
            ->groupBy('teacher_subject_id')
            ->map(fn($items) => $items->keyBy('dimension'));

        // ✅ Logo base64 una sola vez
        $logoPath   = public_path('images/logo-itaf.jpg');
        $logoBase64 = file_exists($logoPath)
            ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath))
            : null;

        $boletines = [];

        foreach ($enrollments as $enrollment) {
            $student = $enrollment->student;
            $scores  = $scoresGrouped[$student->id] ?? collect();

            $allScores = ($allScoresAll[$student->id] ?? collect())
                ->groupBy('teacher_subject_id');

            $puestoIndex = $ranking->search(fn($item) => $item['student_id'] == $student->id);
            $puesto = ($puestoIndex !== false) ? $puestoIndex + 1 : '—';

            $boletines[] = [
                'student'    => $student,
                'scores'     => $scores,
                'allScores'  => $allScores,
                'puesto'     => $puesto,
                'grade'      => optional($enrollment->grade)->name ?? 'N/A',
                'comments'   => $commentsAll,
            ];
        }

        $pdf = Pdf::loadView('admin.boletin.pdf_masivo', [
                'boletines'   => $boletines,
                'period'      => $period,
                'yearLectivo' => $year->year,
                'logoBase64'  => $logoBase64,
                'isPdf'       => true,
            ])
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'dpi'                  => 150,
                'isRemoteEnabled'      => false,
                'isHtml5ParserEnabled' => true,
                'defaultFont'          => 'DejaVu Sans',
            ]);

        return $pdf->download('boletines_grado_' . $gradeId . '.pdf');
    }
}