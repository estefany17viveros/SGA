<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\StudentTurning18Notification;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::with('grade')->get();
        $today = Carbon::today();
        $user = Auth::user();

        $period = $request->period;

        // 🔞 Mayores de edad
        $adultStudents = $students->filter(function ($student) {
            return Carbon::parse($student->birth_date)->age >= 18;
        });

        // ⏳ Próximos a cumplir 18
        $upcomingStudents = [];

        foreach ($students as $student) {

            $fecha18 = Carbon::parse($student->birth_date)->addYears(18);

            if ($fecha18->isFuture()) {

                $diasFaltantes = $today->diffInDays($fecha18, false);

                // 🔔 Notificaciones
                if (in_array($diasFaltantes, [60, 15, 1])) {

                    $mensaje = $diasFaltantes == 60 ? 'Faltan 2 meses para cumplir 18' :
                               ($diasFaltantes == 15 ? 'Faltan 15 días para cumplir 18' :
                               'Mañana cumple 18');

                    if (!$this->yaNotificado($user->id, $student->id, $mensaje)) {
                        $user->notify(new StudentTurning18Notification($student, $mensaje));
                    }
                }

                if ($diasFaltantes <= 60 && $diasFaltantes >= 0) {

                    $student->dias_faltantes = $diasFaltantes;

                    $student->alerta =
                        $diasFaltantes <= 1 ? '⚠️ Mañana cumple 18' :
                        ($diasFaltantes <= 7 ? '🟠 Menos de 7 días' :
                        ($diasFaltantes <= 15 ? '🟡 Menos de 15 días' :
                        '🟢 Menos de 2 meses'));

                    $upcomingStudents[] = $student;
                }
            }
        }

        // 📊 QUERY BASE
        $query = DB::table('scores');

        if ($period) {
            $query->where('scores.period_id', $period);
        }

        // 📉 Materias con bajo rendimiento
        $lowSubjects = $query->clone()
            ->join('teacher_subjects', 'scores.teacher_subject_id', '=', 'teacher_subjects.id')
            ->join('subjects', 'teacher_subjects.subject_id', '=', 'subjects.id')
            ->select('subjects.name', DB::raw('AVG(scores.total) as promedio'))
            ->groupBy('subjects.name')
            ->orderBy('promedio', 'asc')
            ->limit(5)
            ->get();

        // 📈 Mejores materias
        $topSubjects = $query->clone()
            ->join('teacher_subjects', 'scores.teacher_subject_id', '=', 'teacher_subjects.id')
            ->join('subjects', 'teacher_subjects.subject_id', '=', 'subjects.id')
            ->select('subjects.name', DB::raw('AVG(scores.total) as promedio'))
            ->groupBy('subjects.name')
            ->orderBy('promedio', 'desc')
            ->limit(5)
            ->get();

        // 🏫 Mejores grados (CORRECTO CON ENROLLMENTS)
        $topGrades = $query->clone()
            ->join('students', 'scores.student_id', '=', 'students.id')
            ->join('enrollments', 'students.id', '=', 'enrollments.student_id')
            ->join('groups', 'enrollments.group_id', '=', 'groups.id')
            ->join('grades', 'groups.grade_id', '=', 'grades.id')
            ->select('grades.name', DB::raw('AVG(scores.total) as promedio'))
            ->groupBy('grades.name')
            ->orderBy('promedio', 'desc')
            ->limit(5)
            ->get();

        // 🏆 Ranking por grado
        $rankingQuery = DB::table('scores');

        if ($period) {
            $rankingQuery->where('scores.period_id', $period);
        }

        $rankingStudents = $rankingQuery
            ->join('students', 'scores.student_id', '=', 'students.id')
            ->join('enrollments', 'students.id', '=', 'enrollments.student_id')
            ->join('groups', 'enrollments.group_id', '=', 'groups.id')
            ->join('grades', 'groups.grade_id', '=', 'grades.id')
            ->select(
                'students.id',
                'students.first_name',
                'students.last_name',
                'grades.name as grade_name',
                DB::raw('AVG(scores.total) as promedio')
            )
            ->groupBy(
                'students.id',
                'students.first_name',
                'students.last_name',
                'grades.name'
            )
            ->orderBy('grade_name')
            ->orderByDesc('promedio')
            ->get()
            ->groupBy('grade_name');

        return view('dashboard', [
            'totalStudents' => $students->count(),
            'adultStudentsCount' => $adultStudents->count(),
            'adultStudents' => $adultStudents,
            'upcomingStudents' => $upcomingStudents,
            'lowSubjects' => $lowSubjects,
            'topSubjects' => $topSubjects,
            'topGrades' => $topGrades,
            'rankingStudents' => $rankingStudents,
            'period' => $period
        ]);
    }

    private function yaNotificado($userId, $studentId, $mensaje)
    {
        return DB::table('notifications')
            ->where('notifiable_id', $userId)
            ->where('data->student_id', $studentId)
            ->where('data->mensaje', $mensaje)
            ->exists();
    }
}