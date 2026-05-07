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
use App\Models\TeacherSubject;
use App\Models\DisciplinaryNote;

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
    ->join('students', 'enrollments.student_id', '=', 'students.id')
    ->where('enrollments.grade_id', $id)
    ->where('enrollments.academic_year_id', $year->id)
    ->orderBy('students.last_name', 'asc')
    ->orderBy('students.first_name', 'asc')
    ->select('enrollments.*')
    ->get();

        $periods = Period::where('academic_year_id', $year->id)->get();

        return view('admin.boletin.grade', compact(
            'enrollments',
            'periods'
        ))->with('gradeId', $id);
    }

    /**
     * ═══════════════════════════════════════
     * COMENTARIO DISCIPLINA
     * ═══════════════════════════════════════
     */
   private function getDisciplineComment($periodId, $yearId, $gradeId)
{
    return DimensionComment::where('dimension', 'disciplina')
        ->where('period_id', $periodId)
        ->where('academic_year_id', $yearId)
        ->latest()
        ->first();
}
    /**
     * ═══════════════════════════════════════
     * NOTA REAL DE DISCIPLINA
     * ═══════════════════════════════════════
     */
    private function getDisciplineNote($studentId, $gradeId)
    {
        $note = DisciplinaryNote::where('student_id', $studentId)
            ->where('grade_id', $gradeId)
            ->latest()
            ->first();

        if (!$note) {
            return 0;
        }

        // 🔥 SIN REDONDEAR
        return floor(((float)$note->note) * 10) / 10;
    }

    /**
     * ═══════════════════════════════════════
     * DIRECTOR DE GRADO
     * ═══════════════════════════════════════
     */
    private function getDirectorName($gradeId, $yearId)
    {
        $director = Grade::with('director.user')
            ->where('id', $gradeId)
            ->first();

        return optional(optional($director?->director)->user)->name
            ?? 'Director(a) de Grado';
    }

    /**
     * ═══════════════════════════════════════
     * RANKING
     * ═══════════════════════════════════════
     */
    private function getRanking($gradeId, $yearId, $periodId)
    {
        return Score::where('period_id', $periodId)
            ->whereIn(
                'student_id',
                Enrollment::where('grade_id', $gradeId)
                    ->where('academic_year_id', $yearId)
                    ->pluck('student_id')
            )
            ->get()
            ->groupBy('student_id')
            ->map(function ($items) {

                $items = $items->whereNotNull('total');

                if ($items->count() <= 0) {
                    return 0;
                }

                $sum = 0;

                foreach ($items as $item) {

                    // 🔥 USAR VALOR ORIGINAL
                $nota = floor(((float)$item->total) * 10) / 10;

                    $sum += $nota;
                }

                $promedio = $sum / $items->count();

                // 🔥 TRUNCAR SIN REDONDEAR
                return floor($promedio * 10) / 10;
            })
            ->sortDesc()
            ->keys()
            ->toArray();
    }

    /**
     * ═══════════════════════════════════════
     * PROMEDIO ACUMULADO REAL
     * ═══════════════════════════════════════
     */
   private function getPromedioAcumulado($studentId, $gradeId)
{
    $scores = Score::where('student_id', $studentId)
        ->whereNotNull('total')
        ->get()
        ->groupBy('teacher_subject_id');

    if ($scores->count() <= 0) {
        return '0.0';
    }

    $sumaGeneral = 0;
    $cantidadMaterias = 0;

    foreach ($scores as $materiaScores) {

        $sumaMateria = 0;
        $cantidadNotas = 0;

        foreach ($materiaScores as $score) {

            // truncar cada nota
            $nota = floor(((float)$score->total) * 10) / 10;

            $sumaMateria += $nota;
            $cantidadNotas++;
        }

        if ($cantidadNotas > 0) {

            // promedio de la materia
            $promMateria = $sumaMateria / $cantidadNotas;

            // truncar promedio materia
            $promMateria = floor($promMateria * 10) / 10;

            $sumaGeneral += $promMateria;
            $cantidadMaterias++;
        }
    }

    // incluir disciplina
    $disciplina = DisciplinaryNote::where('student_id', $studentId)
        ->where('grade_id', $gradeId)
        ->latest()
        ->first();

    if ($disciplina) {

        $notaDisciplina =
            floor(((float)$disciplina->note) * 10) / 10;

        $sumaGeneral += $notaDisciplina;
        $cantidadMaterias++;
    }

    if ($cantidadMaterias <= 0) {
        return '0.0';
    }

    // promedio final acumulado
    $promedio = $sumaGeneral / $cantidadMaterias;

    // truncar sin redondear
    $promedio = floor($promedio * 100) / 100;

    return number_format($promedio, 2, '.', '');
}
    /**
     * ═══════════════════════════════════════
     * BOLETÍN WEB
     * ═══════════════════════════════════════
     */
    public function show($studentId, $periodId)
    {
        $year = AcademicYear::where('status', 'activo')->first();

        if (!$year) {
            abort(404, 'No hay año activo');
        }

        $student = Student::findOrFail($studentId);

        $period = Period::findOrFail($periodId);

        $enrollment = Enrollment::with('grade')
            ->where('student_id', $studentId)
            ->where('academic_year_id', $year->id)
            ->firstOrFail();

        $scores = Score::with([
                'teacherSubject.subject',
                'teacherSubject.teacher.user',
            ])
            ->where('student_id', $studentId)
            ->where('period_id', $periodId)
            ->get();

        $allScores = Score::with('period')
            ->where('student_id', $studentId)
            ->get()
            ->groupBy('teacher_subject_id');

        $scoresGrado = $this->getRanking(
            $enrollment->grade_id,
            $year->id,
            $periodId
        );

        $puesto = array_search($studentId, $scoresGrado);

        $puesto = ($puesto !== false)
            ? $puesto + 1
            : '—';

        // 🔥 PROMEDIO REAL
        $promedioAcumulado = $this->getPromedioAcumulado(
    $studentId,
    $enrollment->grade_id
);
        // 🔥 NOTA DISCIPLINA REAL
        $disciplineNote = $this->getDisciplineNote(
            $studentId,
            $enrollment->grade_id
        );

       $disciplineComment = $this->getDisciplineComment(
    $periodId,
    $year->id,
    $enrollment->grade_id
);

        $directorName = $this->getDirectorName(
            $enrollment->grade_id,
            $year->id
        );

        $logoPath = public_path('images/logo-itaf.jpg');

        $logoBase64 = file_exists($logoPath)
            ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath))
            : null;

        $allPeriods = Period::where('academic_year_id', $year->id)
            ->orderBy('id')
            ->get();

        $lastPeriod = $allPeriods->last();

        return view('admin.boletin.show', compact(
            'student',
            'period',
            'scores',
            'allScores',
            'puesto',
            'logoBase64',
            'lastPeriod',
            'disciplineComment',
            'directorName',
            'promedioAcumulado',
            'disciplineNote'
        ))->with([
            'grade'       => optional($enrollment->grade)->name ?? 'N/A',
            'yearLectivo' => $year->year,
        ]);
    }

    /**
     * ═══════════════════════════════════════
     * PDF INDIVIDUAL
     * ═══════════════════════════════════════
     */
    public function pdf($studentId, $periodId)
    {
        $year = AcademicYear::where('status', 'activo')->first();

        if (!$year) {
            abort(404, 'No hay año activo');
        }

        $student = Student::findOrFail($studentId);

        $period = Period::findOrFail($periodId);

        $enrollment = Enrollment::with('grade')
            ->where('student_id', $studentId)
            ->where('academic_year_id', $year->id)
            ->firstOrFail();

        $scores = Score::with([
                'teacherSubject.subject',
                'teacherSubject.teacher.user',
            ])
            ->where('student_id', $studentId)
            ->where('period_id', $periodId)
            ->get();

        $allScores = Score::with('period')
            ->where('student_id', $studentId)
            ->get()
            ->groupBy('teacher_subject_id');

        $scoresGrado = $this->getRanking(
            $enrollment->grade_id,
            $year->id,
            $periodId
        );

        $puesto = array_search($studentId, $scoresGrado);

        $puesto = ($puesto !== false)
            ? $puesto + 1
            : '—';

        $promedioAcumulado = $this->getPromedioAcumulado(
            $studentId,
            $enrollment->grade_id
        );

        $disciplineNote = $this->getDisciplineNote(
            $studentId,
            $enrollment->grade_id
        );

        $disciplineComment = $this->getDisciplineComment(
            $periodId,
            $year->id,
            $enrollment->grade_id
        );

        $directorName = $this->getDirectorName(
            $enrollment->grade_id,
            $year->id
        );

        $logoPath = public_path('images/logo-itaf.jpg');

        $logoBase64 = file_exists($logoPath)
            ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath))
            : null;

        $allPeriods = Period::where('academic_year_id', $year->id)
            ->orderBy('id')
            ->get();

        $lastPeriod = $allPeriods->last();

        $pdf = Pdf::loadView('admin.boletin.show', [
                'student'           => $student,
                'period'            => $period,
                'scores'            => $scores,
                'allScores'         => $allScores,
                'puesto'            => $puesto,
                'grade'             => optional($enrollment->grade)->name ?? 'N/A',
                'yearLectivo'       => $year->year,
                'logoBase64'        => $logoBase64,
                'lastPeriod'        => $lastPeriod,
                'disciplineComment' => $disciplineComment,
                'directorName'      => $directorName,
                'promedioAcumulado' => $promedioAcumulado,
                'disciplineNote'    => $disciplineNote,
                'isPdf'             => true,
            ])
            ->setPaper('a4', 'portrait');

        return $pdf->download('boletin.pdf');
    }

    /**
     * ═══════════════════════════════════════
     * PDF MASIVO
     * ═══════════════════════════════════════
     */
    public function pdfMasivo($gradeId, $periodId)
    {
        ini_set('memory_limit', '512M');

        set_time_limit(300);

        $year = AcademicYear::where('status', 'activo')->first();

        if (!$year) {
            abort(404, 'No hay año activo');
        }

        $period = Period::findOrFail($periodId);
$studentIds = Enrollment::join(
        'students',
        'enrollments.student_id',
        '=',
        'students.id'
    )
    ->where('enrollments.grade_id', $gradeId)
    ->where('enrollments.academic_year_id', $year->id)
    ->orderBy('students.last_name', 'asc')
    ->orderBy('students.first_name', 'asc')
    ->pluck('enrollments.student_id')
    ->unique()
    ->values();


        if ($studentIds->isEmpty()) {
            abort(404, 'No hay estudiantes');
        }

       $enrollmentsByStudent = Enrollment::with([
        'student',
        'grade'
    ])
    ->join('students', 'enrollments.student_id', '=', 'students.id')
    ->where('enrollments.grade_id', $gradeId)
    ->where('enrollments.academic_year_id', $year->id)
    ->orderBy('students.last_name', 'asc')
    ->orderBy('students.first_name', 'asc')
    ->select('enrollments.*')
    ->get()
    ->keyBy('student_id');

        $scoresGrouped = Score::with([
                'teacherSubject.subject',
                'teacherSubject.teacher.user',
            ])
            ->where('period_id', $periodId)
            ->whereIn('student_id', $studentIds)
            ->get()
            ->groupBy('student_id');

        $ranking = $scoresGrouped
            ->map(function ($items, $sid) {

                $items = $items->whereNotNull('total');

                if ($items->count() <= 0) {
                    return [
                        'student_id' => $sid,
                        'promedio' => 0
                    ];
                }

                $sum = 0;

                foreach ($items as $item) {
                    $sum += (float)$item->total;
                }

                $promedio = $sum / $items->count();

                return [
                    'student_id' => $sid,
                    'promedio' => floor($promedio * 10) / 10,
                ];
            })
            ->sortByDesc('promedio')
            ->values();

        $allScoresAll = Score::with('period')
            ->whereIn('student_id', $studentIds)
            ->get()
            ->groupBy('student_id')
            ->map(fn($items) => $items->groupBy('teacher_subject_id'));

        $disciplineComment = $this->getDisciplineComment(
    $periodId,
    $year->id,
    $gradeId
);

        $directorName = $this->getDirectorName(
            $gradeId,
            $year->id
        );

        $logoPath = public_path('images/logo-itaf.jpg');

        $logoBase64 = file_exists($logoPath)
            ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath))
            : null;

        $allPeriods = Period::where('academic_year_id', $year->id)
            ->orderBy('id')
            ->get();

        $lastPeriod = $allPeriods->last();

        $boletines = [];

        foreach ($studentIds as $sid) {

            $enrollment = $enrollmentsByStudent[$sid] ?? null;

            if (!$enrollment) {
                continue;
            }

            $student = $enrollment->student;

            $studentScores = $scoresGrouped[$sid] ?? collect();

            $allScores = $allScoresAll[$sid] ?? collect();

            $puestoIndex = $ranking->search(
                fn($item) => $item['student_id'] == $sid
            );

           $promedioAcumulado = $this->getPromedioAcumulado(
    $sid,
    $gradeId
);
            $disciplineNote = $this->getDisciplineNote(
                $sid,
                $gradeId
            );

            $boletines[] = [
                'student'           => $student,
                'scores'            => $studentScores,
                'allScores'         => $allScores,
                'puesto'            => $puestoIndex !== false ? $puestoIndex + 1 : '—',
                'grade'             => optional($enrollment->grade)->name ?? 'N/A',
                'disciplineComment' => $disciplineComment,
                'directorName'      => $directorName,
                'promedioAcumulado' => $promedioAcumulado,
                'disciplineNote'    => $disciplineNote,
            ];
        }

        return Pdf::loadView('admin.boletin.pdf_masivo', [
                'boletines'   => $boletines,
                'period'      => $period,
                'yearLectivo' => $year->year,
                'logoBase64'  => $logoBase64,
                'lastPeriod'  => $lastPeriod,
                'isPdf'       => true,
            ])
            ->setPaper('a4', 'portrait')
            ->download('boletines_grado_' . $gradeId . '.pdf');
    }
}