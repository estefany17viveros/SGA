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

        /*
        |--------------------------------------------------------------------------
        | FILTRO GÉNERO
        |--------------------------------------------------------------------------
        */

        if ($genderFilter) {

            $studentsQuery->where(function ($q) use ($genderFilter) {

                $q->where('gender', $genderFilter)
                  ->orWhere('gender', strtolower($genderFilter))
                  ->orWhere('gender', strtoupper($genderFilter));
            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTRO AÑO
        |--------------------------------------------------------------------------
        */

        if ($year) {
            $studentsQuery->whereYear('created_at', $year);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTRO GRADO
        |--------------------------------------------------------------------------
        */

        if ($gradeId) {

            $studentsQuery->whereHas('enrollments', function ($q) use ($gradeId) {

                $q->where('grade_id', $gradeId);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | OBTENER ESTUDIANTES
        |--------------------------------------------------------------------------
        */

        $students = $studentsQuery->get();

        /*
        |--------------------------------------------------------------------------
        | FILTRO EDADES
        |--------------------------------------------------------------------------
        */

        if ($ageRange) {

            [$minAge, $maxAge] = explode('-', $ageRange);

            $students = $students->filter(function ($student) use ($minAge, $maxAge) {

                $age = Carbon::parse($student->birth_date)->age;

                return $age >= $minAge && $age <= $maxAge;
            });
        }

        /*
        |--------------------------------------------------------------------------
        | TOTAL ESTUDIANTES
        |--------------------------------------------------------------------------
        */

        $totalStudents = $students->count();

        /*
        |--------------------------------------------------------------------------
        | MAYORES DE EDAD
        |--------------------------------------------------------------------------
        */

        $adultStudents = $students->filter(function ($student) {

            return Carbon::parse($student->birth_date)->age >= 18;
        });

        $adultStudentsCount = $adultStudents->count();

        /*
        |--------------------------------------------------------------------------
        | PRÓXIMOS A LOS 18
        |--------------------------------------------------------------------------
        */

        $upcomingStudents = [];

        foreach ($students as $student) {

            $birthDate = Carbon::parse($student->birth_date);

            $next18 = $birthDate->copy()->addYears(18);

            $daysLeft = now()->diffInDays($next18, false);

            if ($daysLeft >= 0 && $daysLeft <= 365) {

                $student->dias_faltantes = $daysLeft;

                if ($daysLeft <= 30) {

                    $student->alerta = 'Urgente';

                } elseif ($daysLeft <= 90) {

                    $student->alerta = 'Próximo';

                } else {

                    $student->alerta = 'Seguimiento';
                }

                $upcomingStudents[] = $student;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | DISTRIBUCIÓN POR EDADES
        |--------------------------------------------------------------------------
        */

        $range1 = 0;
        $range2 = 0;
        $range3 = 0;

        foreach ($students as $student) {

            $age = Carbon::parse($student->birth_date)->age;

            if ($age >= 9 && $age <= 12) {

                $range1++;

            } elseif ($age >= 13 && $age <= 15) {

                $range2++;

            } elseif ($age >= 16 && $age <= 19) {

                $range3++;
            }
        }

        $ageDistribution = [

            [
                'label' => '9 - 12 años',
                'count' => $range1
            ],

            [
                'label' => '13 - 15 años',
                'count' => $range2
            ],

            [
                'label' => '16 - 19 años',
                'count' => $range3
            ]
        ];

        /*
        |--------------------------------------------------------------------------
        | DISTRIBUCIÓN GÉNERO
        |--------------------------------------------------------------------------
        */

        $genderDistribution = [

            'M' => [
                'count' => $students->filter(function ($s) {

                    return in_array(strtolower($s->gender), [
                        'm',
                        'masculino'
                    ]);
                })->count()
            ],

            'F' => [
                'count' => $students->filter(function ($s) {

                    return in_array(strtolower($s->gender), [
                        'f',
                        'femenino'
                    ]);
                })->count()
            ]
        ];

        /*
        |--------------------------------------------------------------------------
        | GÉNERO POR RANGO
        |--------------------------------------------------------------------------
        */

        $genderByAgeRange = [

            [
                'range' => '9 - 12',
                'masculino' => 0,
                'femenino' => 0
            ],

            [
                'range' => '13 - 15',
                'masculino' => 0,
                'femenino' => 0
            ],

            [
                'range' => '16 - 19',
                'masculino' => 0,
                'femenino' => 0
            ]
        ];

        foreach ($students as $student) {

            $age = Carbon::parse($student->birth_date)->age;

            $isMale = in_array(strtolower($student->gender), [
                'm',
                'masculino'
            ]);

            if ($age >= 9 && $age <= 12) {

                if ($isMale) {

                    $genderByAgeRange[0]['masculino']++;

                } else {

                    $genderByAgeRange[0]['femenino']++;
                }

            } elseif ($age >= 13 && $age <= 15) {

                if ($isMale) {

                    $genderByAgeRange[1]['masculino']++;

                } else {

                    $genderByAgeRange[1]['femenino']++;
                }

            } elseif ($age >= 16 && $age <= 19) {

                if ($isMale) {

                    $genderByAgeRange[2]['masculino']++;

                } else {

                    $genderByAgeRange[2]['femenino']++;
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | AÑOS
        |--------------------------------------------------------------------------
        */

        $years = Student::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        /*
        |--------------------------------------------------------------------------
        | GRADOS
        |--------------------------------------------------------------------------
        */

        $grades = Grade::orderBy('name')->get();

        /*
        |--------------------------------------------------------------------------
        | QUERY SCORES
        |--------------------------------------------------------------------------
        */

        $scoresQuery = Score::with([
            'student',
            'teacherSubject.subject',
            'teacherSubject.grade'
        ]);

        /*
        |--------------------------------------------------------------------------
        | FILTRO PERIODO
        |--------------------------------------------------------------------------
        */

        if ($period) {

            $scoresQuery->where('period_id', $period);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTRO GRADO SCORES
        |--------------------------------------------------------------------------
        */

        if ($gradeId) {

            $scoresQuery->whereHas('teacherSubject', function ($q) use ($gradeId) {

                $q->where('grade_id', $gradeId);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTRO GÉNERO SCORES
        |--------------------------------------------------------------------------
        */

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
        | ESTUDIANTES POR NIVEL
        |--------------------------------------------------------------------------
        */

        $studentsByLevel = [

            'superior' => 0,
            'alto'     => 0,
            'basico'   => 0,
            'bajo'     => 0
        ];

        /*
        |--------------------------------------------------------------------------
        | PERFORMANCE LEVELS
        |--------------------------------------------------------------------------
        */

        $performanceLevels = [

            'superior' => [
                'label' => 'Superior',
                'count' => 0,
                'subjects' => []
            ],

            'alto' => [
                'label' => 'Alto',
                'count' => 0,
                'subjects' => []
            ],

            'basico' => [
                'label' => 'Básico',
                'count' => 0,
                'subjects' => []
            ],

            'bajo' => [
                'label' => 'Bajo',
                'count' => 0,
                'subjects' => []
            ]
        ];

        foreach ($scores as $score) {

            if (!$score->total) {
                continue;
            }

            $nota = (float) $score->total;

            if ($nota >= 4.6) {

                $nivel = 'superior';

            } elseif ($nota >= 4.0) {

                $nivel = 'alto';

            } elseif ($nota >= 3.0) {

                $nivel = 'basico';

            } else {

                $nivel = 'bajo';
            }

            $studentsByLevel[$nivel]++;

            $performanceLevels[$nivel]['count']++;

            $performanceLevels[$nivel]['subjects'][] = [

                'subject' => optional(
                    optional($score->teacherSubject)->subject
                )->name ?? 'N/A',

                'grade' => optional(
                    optional($score->teacherSubject)->grade
                )->name ?? 'N/A',

                'promedio' => number_format($nota, 1)
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | DESEMPEÑO POR GRADO
        |--------------------------------------------------------------------------
        */

        $performanceByGrade = [];

        $groupedGrades = $scores->groupBy(function ($score) {

            return optional(
                optional($score->teacherSubject)->grade
            )->name ?? 'Sin grado';
        });

        foreach ($groupedGrades as $gradeName => $gradeScores) {

            $superior = 0;
            $alto = 0;
            $basico = 0;
            $bajo = 0;

            foreach ($gradeScores as $score) {

                $nota = (float) $score->total;

                if ($nota >= 4.6) {

                    $superior++;

                } elseif ($nota >= 4.0) {

                    $alto++;

                } elseif ($nota >= 3.0) {

                    $basico++;

                } else {

                    $bajo++;
                }
            }

            $performanceByGrade[] = [

                'grade'    => $gradeName,
                'superior' => $superior,
                'alto'     => $alto,
                'basico'   => $basico,
                'bajo'     => $bajo
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | RANKING ESTUDIANTES
        |--------------------------------------------------------------------------
        */

        $rankingStudents = Student::with('enrollments.grade')
            ->get()
            ->map(function ($student) {

                $promedio = Score::where(
                    'student_id',
                    $student->id
                )->avg('total');

                $student->promedio = $promedio ?? 0;

                return $student;
            })
            ->sortByDesc('promedio')
            ->groupBy(function ($student) {

                return optional(
                    optional($student->enrollments->first())->grade
                )->name ?? 'Sin grado';
            });

        /*
        |--------------------------------------------------------------------------
        | BAJO RENDIMIENTO
        |--------------------------------------------------------------------------
        */

        $lowSubjects = Score::select(
                DB::raw('AVG(total) as promedio'),
                'teacher_subject_id'
            )
            ->with('teacherSubject.subject')
            ->groupBy('teacher_subject_id')
            ->orderBy('promedio')
            ->take(5)
            ->get()
            ->map(function ($item) {

                return [

                    'name' => optional(
                        optional($item->teacherSubject)->subject
                    )->name ?? 'N/A',

                    'promedio' => round($item->promedio, 1)
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | MEJOR RENDIMIENTO
        |--------------------------------------------------------------------------
        */

        $topSubjects = Score::select(
                DB::raw('AVG(total) as promedio'),
                'teacher_subject_id'
            )
            ->with('teacherSubject.subject')
            ->groupBy('teacher_subject_id')
            ->orderByDesc('promedio')
            ->take(5)
            ->get()
            ->map(function ($item) {

                return [

                    'name' => optional(
                        optional($item->teacherSubject)->subject
                    )->name ?? 'N/A',

                    'promedio' => round($item->promedio, 1)
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | TOP GRADOS
        |--------------------------------------------------------------------------
        */

        $topGrades = Score::join(
                'teacher_subjects',
                'scores.teacher_subject_id',
                '=',
                'teacher_subjects.id'
            )
            ->join(
                'grades',
                'teacher_subjects.grade_id',
                '=',
                'grades.id'
            )
            ->select(
                'grades.name',
                DB::raw('AVG(scores.total) as promedio')
            )
            ->groupBy('grades.name')
            ->orderByDesc('promedio')
            ->take(6)
            ->get()
            ->map(function ($item) {

                return [

                    'name' => $item->name,
                    'promedio' => round($item->promedio, 1)
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | RETORNAR VISTA
        |--------------------------------------------------------------------------
        */

        return view('dashboard', compact(

            'totalStudents',
            'adultStudents',
            'adultStudentsCount',
            'upcomingStudents',

            'grades',
            'gradeId',

            'ageRange',
            'ageDistribution',

            'year',
            'years',

            'genderFilter',
            'genderDistribution',
            'genderByAgeRange',

            'studentsByLevel',
            'performanceLevels',
            'performanceByGrade',

            'rankingStudents',

            'lowSubjects',
            'topSubjects',
            'topGrades',

            'period'
        ));
    }
}