<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Score;
use App\Models\TeacherSubject;
use App\Models\Student;
use App\Models\AcademicYear;
use App\Models\Period;
use App\Exports\ScoresTemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ScoresImport;


class ScoreController extends Controller
{

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
        'teacher_subject_id' => 'required',
        'period_id' => 'required'
    ]);

    Excel::import(
        new ScoresImport(
            $request->teacher_subject_id,
            $request->period_id
        ),
        $request->file('file')
    );

    return back()->with('success', 'Notas importadas correctamente');
}


public function export($teacherSubjectId)
{
    $assignment = TeacherSubject::findOrFail($teacherSubjectId);

    $year = AcademicYear::where('status', 'activo')->first();

   $students = Student::whereHas('enrollments', function ($q) use ($assignment, $year) {
    $q->where('grade_id', $assignment->grade_id)
      ->where('academic_year_id', $year->id);
})
->orderBy('last_name', 'asc') // 👈 APELLIDO
->get();

    return Excel::download(
        new ScoresTemplateExport($students),
        'plantilla_notas.xlsx'
    );
}
    /**
     * 📊 VER NOTAS + RANKING
     */
    public function index($teacherSubjectId)
    {
        $user = Auth::user();

        if (!$user || !$user->teacher) {
            abort(403);
        }

        $teacher = $user->teacher;

        $assignment = TeacherSubject::where('teacher_id', $teacher->id)
            ->with(['subject', 'grade'])
            ->findOrFail($teacherSubjectId);

        $year = AcademicYear::where('status', 'activo')->first();

        if (!$year) {
            return back()->with('error', 'No hay año académico activo');
        }

        $period = Period::where('academic_year_id', $year->id)
            ->where('status', 'activo')
            ->first();

        if (!$period) {
            return back()->with('error', 'No hay periodo activo');
        }

      $students = Student::whereHas('enrollments', function ($q) use ($assignment, $year) {
    $q->where('grade_id', $assignment->grade_id)
      ->where('academic_year_id', $year->id);
})
->orderByRaw('LOWER(last_name) ASC')   // 🔥 APELLIDO primero
->orderByRaw('LOWER(first_name) ASC')  // 🔥 luego nombre
->get();

        $scores = Score::where('teacher_subject_id', $assignment->id)
            ->where('period_id', $period->id)
            ->get()
            ->keyBy('student_id');

        $ranking = [];

        foreach ($students as $student) {

            $score = $scores[$student->id] ?? null;

            $ranking[] = [
                'student' => $student,
                'score'   => $score,
                'total'   => $score->total ?? 0
            ];
        }

       
// 🔥 CLONAR Y ORDENAR POR PROMEDIO
$sortedRanking = collect($ranking)
    ->sortByDesc('total')
    ->values();

// 🔥 ASIGNAR PUESTOS ÚNICOS
$positions = [];

foreach ($sortedRanking as $index => $item) {

    $studentId = $item['student']->id;

    $positions[$studentId] = $index + 1;
}

// 🔥 AGREGAR POSICIÓN AL RANKING ORIGINAL
foreach ($ranking as &$item) {

    $studentId = $item['student']->id;

    $item['position'] = $positions[$studentId] ?? 0;
}

        return view('teacher.scores.index', compact(
            'ranking',
            'assignment',
            'period'
        ));
    }

    /**
     * 💾 GUARDAR NOTAS (POR PERIODO)
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'teacher_subject_id' => 'required|exists:teacher_subjects,id',
            'period_id' => 'required|exists:periods,id',
            'scores' => 'required|array'
        ]);

        foreach ($request->scores as $student_id => $data) {

            $saber = $data['saber'] ?? null;
            $hacer = $data['hacer'] ?? null;
            $ser   = $data['ser'] ?? null;
            $fj = intval($data['justified_absences'] ?? 0);
$fi = intval($data['unjustified_absences'] ?? 0);

            if (
                is_null($saber) || $saber === '' ||
                is_null($hacer) || $hacer === '' ||
                is_null($ser) || $ser === ''
            ) {
                return back()->with('error',
                    "❌ Debes completar TODAS las notas (Saber, Hacer y Ser)"
                );
            }

            $saber = floatval($saber);
            $hacer = floatval($hacer);
            $ser   = floatval($ser);

            if ($saber < 1 || $saber > 5 ||
                $hacer < 1 || $hacer > 5 ||
                $ser < 1 || $ser > 5) {

                return back()->with('error',
                    "❌ Las notas deben estar entre 1.0 y 5.0"
                );
            }

            // ✅ PROMEDIO DEL PERIODO (NO FINAL DEL AÑO)
          $total = ($saber + $hacer + $ser) / 3;

// 🔥 TRUNCAR A 2 DECIMALES
$total = floor($total * 100) / 100;

            Score::updateOrCreate(
                [
                    'student_id' => $student_id,
                    'teacher_subject_id' => $request->teacher_subject_id,
                    'period_id' => $request->period_id
                ],
                [
    'saber' => $saber,
    'hacer' => $hacer,
    'ser'   => $ser,
    'justified_absences' => $fj,
    'unjustified_absences' => $fi,
    'total' => $total
]
            );
        }

        return back()->with('success', '✅ Notas del periodo guardadas correctamente');
    }

    /**
     * ✏️ ACTUALIZAR (AJAX)
     */
    public function update(Request $request, $id)
    {
        $score = Score::findOrFail($id);

        $request->validate([
            'saber' => 'nullable|numeric|min:1|max:5',
            'hacer' => 'nullable|numeric|min:1|max:5',
            'ser'   => 'nullable|numeric|min:1|max:5',
        'justified_absences' => 'nullable|integer|min:0',
'unjustified_absences' => 'nullable|integer|min:0',
            ]);

        $saber = $request->saber;
        $hacer = $request->hacer;
        $ser   = $request->ser;

        $total = null;

        if ($saber !== null && $hacer !== null && $ser !== null) {

    $total = ($saber + $hacer + $ser) / 3;

    // 🔥 TRUNCAR
    $total = floor($total * 100) / 100;
}

        $score->update([
            'saber' => $saber,
            'hacer' => $hacer,
            'ser'   => $ser,
            'justified_absences' => $request->justified_absences,
            'unjustified_absences' => $request->unjustified_absences,
            'total' => $total
        ]);

        return response()->json([
            'success' => true,
            'total' => $total
        ]);
    }

    /**
     * 🗑️ ELIMINAR
     */
    public function destroy($id)
    {
        $score = Score::findOrFail($id);
        $score->delete();

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * 🧠 (NUEVO) NOTA FINAL DEL AÑO POR ESTUDIANTE
     */
    public function finalScore($studentId, $teacherSubjectId)
{
    $scores = Score::with('period')
        ->where('student_id', $studentId)
        ->where('teacher_subject_id', $teacherSubjectId)
        ->get();

    if ($scores->isEmpty()) {
        return 0;
    }

    $final = 0;

    foreach ($scores as $score) {

        if ($score->period && $score->period->percentage) {

            $porcentaje = $score->period->percentage / 100;

            $final += $score->total * $porcentaje;
        }
    }

  return floor($final * 100) / 100;
}
}