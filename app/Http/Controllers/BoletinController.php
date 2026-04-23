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

        $allPeriods = Period::where('academic_year_id', $year->id)
            ->orderBy('id')
            ->get();

        $lastPeriod = $allPeriods->last();

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

        $logoPath   = public_path('images/logo-itaf.jpg');
        $logoBase64 = file_exists($logoPath)
            ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath))
            : null;

        return view('admin.boletin.show', compact(
            'student',
            'period',
            'scores',
            'allScores',
            'puesto',
            'logoBase64',
            'lastPeriod'
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

        $allPeriods = Period::where('academic_year_id', $year->id)
            ->orderBy('id')
            ->get();

        $lastPeriod = $allPeriods->last();

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
                'lastPeriod'  => $lastPeriod,
                'isPdf'       => true,
            ])
            ->setPaper('a4', 'portrait');

        return $pdf->download('boletin.pdf');
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

        // ✅ 1. UN enrollment por estudiante — sin duplicados
        //    Usamos groupBy en SQL level para evitar que unique() en colección
        //    falle si hay IDs de enrollment distintos para el mismo student_id
        $studentIds = Enrollment::where('grade_id', $gradeId)
            ->where('academic_year_id', $year->id)
            ->pluck('student_id')
            ->unique()          // elimina student_ids repetidos
            ->values();

        if ($studentIds->isEmpty()) abort(404, 'No hay estudiantes');

        // Cargamos enrollments — uno por student_id garantizado
        $enrollmentsByStudent = Enrollment::with(['student', 'grade'])
            ->where('grade_id', $gradeId)
            ->where('academic_year_id', $year->id)
            ->get()
            ->keyBy('student_id');   // keyed por student_id → máximo 1 por estudiante

        // ✅ 2. Notas del periodo agrupadas por student_id
        $scoresGrouped = Score::with([
                'teacherSubject.subject',
                'teacherSubject.teacher.user'
            ])
            ->where('period_id', $periodId)
            ->whereIn('student_id', $studentIds)
            ->get()
            ->groupBy('student_id');

        // ✅ 3. Ranking
        $ranking = $scoresGrouped
            ->map(fn($items, $sid) => [
                'student_id' => $sid,
                'promedio'   => round($items->avg('total'), 2),
            ])
            ->sortByDesc('promedio')
            ->values();

        // ✅ 4. Historial completo agrupado por student_id → teacher_subject_id
        $allScoresAll = Score::with('period')
            ->whereIn('student_id', $studentIds)
            ->get()
            ->groupBy('student_id')
            ->map(fn($items) => $items->groupBy('teacher_subject_id'));

        // ✅ 5. Logo
        $logoPath   = public_path('images/logo-itaf.jpg');
        $logoBase64 = file_exists($logoPath)
            ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath))
            : null;

        // ✅ 6. Construir boletines — iteramos sobre studentIds únicos
        $boletines = [];

        foreach ($studentIds as $sid) {

            $enrollment = $enrollmentsByStudent[$sid] ?? null;
            if (!$enrollment) continue;   // seguridad extra

            $student       = $enrollment->student;
            $studentScores = $scoresGrouped[$sid] ?? collect();
            $allScores     = $allScoresAll[$sid]   ?? collect();

            $puestoIndex = $ranking->search(fn($item) => $item['student_id'] == $sid);

            $boletines[] = [
                'student'   => $student,
                'scores'    => $studentScores,
                'allScores' => $allScores,   // ya es teacher_subject_id => scores
                'puesto'    => $puestoIndex !== false ? $puestoIndex + 1 : '—',
                'grade'     => optional($enrollment->grade)->name ?? 'N/A',
            ];
        }

        // ✅ 7. Generar PDF
        return Pdf::loadView('admin.boletin.pdf_masivo', [
                'boletines'   => $boletines,
                'period'      => $period,
                'yearLectivo' => $year->year,
                'logoBase64'  => $logoBase64,
                'isPdf'       => true,
            ])
            ->setPaper('a4', 'portrait')
            ->download('boletines_grado_' . $gradeId . '.pdf');
    }
}