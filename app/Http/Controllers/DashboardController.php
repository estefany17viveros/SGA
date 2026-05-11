<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Grade;
use App\Models\Enrollment;
use App\Models\Score;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTROS
        |--------------------------------------------------------------------------
        */

        $gradeId      = $request->grade_id;
        $ageRange     = $request->age_range;
        $year         = $request->year;
        $genderFilter = $request->gender;
        $period       = $request->period;

        /*
        |--------------------------------------------------------------------------
        | QUERY BASE ESTUDIANTES
        |--------------------------------------------------------------------------
        */

        $studentsQuery = Student::with(['enrollments.grade']);

        if ($genderFilter) {
            $studentsQuery->where(function ($q) use ($genderFilter) {
                $q->where('gender', $genderFilter)
                  ->orWhere('gender', strtolower($genderFilter))
                  ->orWhere('gender', strtoupper($genderFilter));
            });
        }

        if ($year) {
            $studentsQuery->whereYear('created_at', $year);
        }

        if ($gradeId) {
            $studentsQuery->whereHas('enrollments', function ($q) use ($gradeId) {
                $q->where('grade_id', $gradeId);
            });
        }

        $students = $studentsQuery->get();

        if ($ageRange) {
            [$minAge, $maxAge] = explode('-', $ageRange);
            $students = $students->filter(function ($student) use ($minAge, $maxAge) {
                $age = Carbon::parse($student->birth_date)->age;
                return $age >= $minAge && $age <= $maxAge;
            });
        }

        /*
        |--------------------------------------------------------------------------
        | TOTALES ESTUDIANTES
        |--------------------------------------------------------------------------
        */

        $totalStudents      = $students->count();
        $adultStudents      = $students->filter(fn($s) => Carbon::parse($s->birth_date)->age >= 18);
        $adultStudentsCount = $adultStudents->count();

        /*
        |--------------------------------------------------------------------------
        | PRÓXIMOS A LOS 18
        |--------------------------------------------------------------------------
        */

        $upcomingStudents = [];

        foreach ($students as $student) {
            $next18   = Carbon::parse($student->birth_date)->copy()->addYears(18);
            $daysLeft = now()->diffInDays($next18, false);

            if ($daysLeft >= 0 && $daysLeft <= 365) {
                $student->dias_faltantes = $daysLeft;
                $student->alerta = $daysLeft <= 30 ? 'Urgente' : ($daysLeft <= 90 ? 'Próximo' : 'Seguimiento');
                $upcomingStudents[] = $student;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | DISTRIBUCIÓN POR EDADES
        |--------------------------------------------------------------------------
        */

        $range1 = $range2 = $range3 = 0;

        foreach ($students as $student) {
            $age = Carbon::parse($student->birth_date)->age;
            if ($age >= 9 && $age <= 12)       $range1++;
            elseif ($age >= 13 && $age <= 15)  $range2++;
            elseif ($age >= 16 && $age <= 19)  $range3++;
        }

        $ageDistribution = [
            ['label' => '9 - 12 años',  'count' => $range1],
            ['label' => '13 - 15 años', 'count' => $range2],
            ['label' => '16 - 19 años', 'count' => $range3],
        ];

        /*
        |--------------------------------------------------------------------------
        | DISTRIBUCIÓN GÉNERO
        |--------------------------------------------------------------------------
        */

        $genderDistribution = [
            'M' => ['count' => $students->filter(fn($s) => in_array(strtolower($s->gender), ['m', 'masculino']))->count()],
            'F' => ['count' => $students->filter(fn($s) => in_array(strtolower($s->gender), ['f', 'femenino']))->count()],
        ];

        /*
        |--------------------------------------------------------------------------
        | GÉNERO POR RANGO
        |--------------------------------------------------------------------------
        */

        $genderByAgeRange = [
            ['range' => '9 - 12',  'masculino' => 0, 'femenino' => 0],
            ['range' => '13 - 15', 'masculino' => 0, 'femenino' => 0],
            ['range' => '16 - 19', 'masculino' => 0, 'femenino' => 0],
        ];

        foreach ($students as $student) {
            $age    = Carbon::parse($student->birth_date)->age;
            $isMale = in_array(strtolower($student->gender), ['m', 'masculino']);

            if ($age >= 9 && $age <= 12)      $genderByAgeRange[0][$isMale ? 'masculino' : 'femenino']++;
            elseif ($age >= 13 && $age <= 15) $genderByAgeRange[1][$isMale ? 'masculino' : 'femenino']++;
            elseif ($age >= 16 && $age <= 19) $genderByAgeRange[2][$isMale ? 'masculino' : 'femenino']++;
        }

        /*
        |--------------------------------------------------------------------------
        | AÑOS / GRADOS
        |--------------------------------------------------------------------------
        */

        $years  = Student::selectRaw('YEAR(created_at) as year')->distinct()->orderBy('year', 'desc')->pluck('year');
        $grades = Grade::orderBy('name')->get();

        /*
        |--------------------------------------------------------------------------
        | QUERY SCORES
        |--------------------------------------------------------------------------
        */

        $scoresQuery = Score::with(['student', 'teacherSubject.subject', 'teacherSubject.grade']);

        if ($period)       $scoresQuery->where('period_id', $period);
        if ($gradeId)      $scoresQuery->whereHas('teacherSubject', fn($q) => $q->where('grade_id', $gradeId));
        if ($genderFilter) {
            $scoresQuery->whereHas('student', function ($q) use ($genderFilter) {
                $q->where('gender', $genderFilter)
                  ->orWhere('gender', strtolower($genderFilter))
                  ->orWhere('gender', strtoupper($genderFilter));
            });
        }

        $scores = $scoresQuery->get();

        /*
        |--------------------------------------------------------------------------
        | NIVELES DE DESEMPEÑO — conteo de notas por nivel
        |--------------------------------------------------------------------------
        */

        $studentsByLevel = ['superior' => 0, 'alto' => 0, 'basico' => 0, 'bajo' => 0];

        /*
        |--------------------------------------------------------------------------
        | PROMEDIO POR ÁREA/MATERIA agrupado → una fila por materia con su nivel
        |--------------------------------------------------------------------------
        */

        // Agrupar scores por nombre de materia, calcular promedio y nivel
        $subjectAverages = $scores
            ->filter(fn($s) => $s->total !== null)
            ->groupBy(fn($s) => trim(optional(optional($s->teacherSubject)->subject)->name ?? 'Sin materia'))
            ->map(function ($group, $subjectName) {
                $avg   = $group->avg('total');
                $grade = optional(optional($group->first()->teacherSubject)->grade)->name ?? 'N/A';

                if ($avg >= 4.6)      $nivel = 'superior';
                elseif ($avg >= 4.0)  $nivel = 'alto';
                elseif ($avg >= 3.0)  $nivel = 'basico';
                else                  $nivel = 'bajo';

                return [
                    'subject'  => $subjectName,
                    'grade'    => $grade,
                    'promedio' => number_format($avg, 1),
                    'nivel'    => $nivel,
                ];
            })
            ->values();

        // Construir performanceLevels con UNA entrada por materia (no duplicados)
        $performanceLevels = [
            'superior' => ['label' => 'Superior', 'count' => 0, 'subjects' => []],
            'alto'     => ['label' => 'Alto',     'count' => 0, 'subjects' => []],
            'basico'   => ['label' => 'Básico',   'count' => 0, 'subjects' => []],
            'bajo'     => ['label' => 'Bajo',     'count' => 0, 'subjects' => []],
        ];

        foreach ($subjectAverages as $item) {
            $nivel = $item['nivel'];
            $performanceLevels[$nivel]['count']++;
            $performanceLevels[$nivel]['subjects'][] = $item;
        }

        // studentsByLevel: cantidad de notas individuales por nivel (para el pie chart)
        foreach ($scores as $score) {
            if (!$score->total) continue;
            $nota = (float) $score->total;
            if ($nota >= 4.6)      $studentsByLevel['superior']++;
            elseif ($nota >= 4.0)  $studentsByLevel['alto']++;
            elseif ($nota >= 3.0)  $studentsByLevel['basico']++;
            else                   $studentsByLevel['bajo']++;
        }

        /*
        |--------------------------------------------------------------------------
        | DESEMPEÑO POR GRADO
        |--------------------------------------------------------------------------
        */

        $performanceByGrade = [];

        $groupedGrades = $scores->groupBy(fn($s) => optional(optional($s->teacherSubject)->grade)->name ?? 'Sin grado');

        foreach ($groupedGrades as $gradeName => $gradeScores) {
            $sup = $alt = $bas = $baj = 0;
            foreach ($gradeScores as $score) {
                $nota = (float) $score->total;
                if ($nota >= 4.6)      $sup++;
                elseif ($nota >= 4.0)  $alt++;
                elseif ($nota >= 3.0)  $bas++;
                else                   $baj++;
            }
            $performanceByGrade[] = ['grade' => $gradeName, 'superior' => $sup, 'alto' => $alt, 'basico' => $bas, 'bajo' => $baj];
        }

        /*
        |--------------------------------------------------------------------------
        | RANKING ESTUDIANTES
        |--------------------------------------------------------------------------
        */

        $rankingStudents = Student::with('enrollments.grade')
            ->get()
            ->map(function ($student) {
                $student->promedio = Score::where('student_id', $student->id)->avg('total') ?? 0;
                return $student;
            })
            ->sortByDesc('promedio')
            ->groupBy(fn($s) => optional(optional($s->enrollments->first())->grade)->name ?? 'Sin grado');

        /*
        |--------------------------------------------------------------------------
        | MATERIAS — BAJO Y MEJOR RENDIMIENTO
        | Se usa AVG real por materia; se excluyen duplicados con TRIM
        |--------------------------------------------------------------------------
        */

        $subjectsQuery = Score::query()
            ->join('teacher_subjects', 'scores.teacher_subject_id', '=', 'teacher_subjects.id')
            ->join('subjects', 'teacher_subjects.subject_id', '=', 'subjects.id');

        if ($period)  $subjectsQuery->where('scores.period_id', $period);
        if ($gradeId) $subjectsQuery->where('teacher_subjects.grade_id', $gradeId);

        if ($genderFilter) {
            $subjectsQuery->join('students', 'scores.student_id', '=', 'students.id')
                ->where(fn($q) => $q->whereRaw('LOWER(students.gender) = ?', [strtolower($genderFilter)]));
        }

        // Materias con el PROMEDIO más bajo (orden ASC)
        $lowSubjects = (clone $subjectsQuery)
            ->selectRaw('TRIM(subjects.name) as name, ROUND(AVG(scores.total),1) as promedio')
            ->groupByRaw('TRIM(subjects.name)')
            ->orderBy('promedio', 'asc')
            ->take(5)
            ->get();

        // Materias con el PROMEDIO más alto (orden DESC) — clone independiente
        $topSubjects = (clone $subjectsQuery)
            ->selectRaw('TRIM(subjects.name) as name, ROUND(AVG(scores.total),1) as promedio')
            ->groupByRaw('TRIM(subjects.name)')
            ->orderBy('promedio', 'desc')
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | TOP GRADOS
        |--------------------------------------------------------------------------
        */

        $topGrades = Score::join('teacher_subjects', 'scores.teacher_subject_id', '=', 'teacher_subjects.id')
            ->join('grades', 'teacher_subjects.grade_id', '=', 'grades.id')
            ->select('grades.name', DB::raw('AVG(scores.total) as promedio'))
            ->groupBy('grades.name')
            ->orderByDesc('promedio')
            ->take(6)
            ->get()
            ->map(fn($i) => ['name' => $i->name, 'promedio' => round($i->promedio, 1)]);

        /*
        |--------------------------------------------------------------------------
        | RETORNAR VISTA
        |--------------------------------------------------------------------------
        */

        return view('dashboard', compact(
            'totalStudents', 'adultStudents', 'adultStudentsCount', 'upcomingStudents',
            'grades', 'gradeId',
            'ageRange', 'ageDistribution',
            'year', 'years',
            'genderFilter', 'genderDistribution', 'genderByAgeRange',
            'studentsByLevel', 'performanceLevels', 'performanceByGrade',
            'rankingStudents',
            'lowSubjects', 'topSubjects', 'topGrades',
            'period'
        ));
    }
}