<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcademicYear;
use App\Models\Grade;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AcademicYearController extends Controller
{
    /**
     * Listar años académicos
     */
    public function index()
    {
        $academicYears = AcademicYear::orderBy('year', 'desc')->paginate(10);
        return view('admin.academic_years.index', compact('academicYears'));
    }

    /**
     * Formulario crear
     */
    public function create()
    {
        return view('admin.academic_years.create');
    }

    /**
     * Guardar nuevo año académico + TODO automático
     */
   public function store(Request $request)
{
    $request->validate([
        'year' => 'required|integer|unique:academic_years,year',
        'calendar' => 'required|in:A,B',
        'periods' => 'required|integer|min:1',
    ]);

    DB::beginTransaction();

    try {

        // 🔥 Obtener año activo actual
        $oldYear = AcademicYear::where('status', 'activo')->first();

        // 🔥 Cerrar cualquier año activo
        AcademicYear::where('status', 'activo')->update(['status' => 'cerrado']);

        // 🔥 Crear nuevo año
        $newYear = AcademicYear::create([
            'year' => $request->year,
            'calendar' => $request->calendar,
            'periods' => $request->periods,
            'status' => 'activo'
        ]);

        // 🔥 Fechas
        self::setDates($newYear);
        $newYear->save();

        // 🔥 Periodos
        $this->createPeriods($newYear);

        // 🔥 Clonar datos
        if ($oldYear) {
            $this->promoteStudents($oldYear, $newYear);
            $this->cloneTeacherSubjects($oldYear, $newYear);
        }

        DB::commit();

        return redirect()->route('admin.academic_years.index')
            ->with('success', 'Año creado correctamente');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->with('error', $e->getMessage());
    }
}

    /**
     * 🔥 PROMOVER ESTUDIANTES
     */
    private function promoteStudents($oldYear, $newYear)
    {
        $enrollments = Enrollment::where('academic_year_id', $oldYear->id)
            ->with('grade')
            ->get();

        foreach ($enrollments as $enrollment) {

            if ($enrollment->status == 'retirado') {
                continue;
            }

            // 🎓 Graduar
            if ($enrollment->status == 'aprobado' && $enrollment->grade->level == 11) {
                $enrollment->update(['status' => 'graduado']);
                continue;
            }

            $gradeId = $enrollment->grade_id;

            if ($enrollment->status == 'aprobado') {
                $nextGrade = Grade::where('level', $enrollment->grade->level + 1)->first();
                if ($nextGrade) {
                    $gradeId = $nextGrade->id;
                }
            }

            if ($enrollment->status == 'reprobado') {
                $gradeId = $enrollment->grade_id;
            }

            $exists = Enrollment::where('student_id', $enrollment->student_id)
                ->where('academic_year_id', $newYear->id)
                ->exists();

            if (!$exists) {
                Enrollment::create([
                    'student_id' => $enrollment->student_id,
                    'grade_id' => $gradeId,
                    'academic_year_id' => $newYear->id,
                    'group_id' => null,
                    'status' => $enrollment->status == 'reprobado'
                        ? 'reprobado'
                        : 'matriculado'
                ]);
            }
        }
    }

    /**
     * 🔥 CLONAR ASIGNACIONES (LO IMPORTANTE)
     */
    private function cloneTeacherSubjects($oldYear, $newYear)
    {
        $assignments = \App\Models\TeacherSubject::where('academic_year_id', $oldYear->id)->get();

        foreach ($assignments as $assignment) {

            $exists = \App\Models\TeacherSubject::where([
                'teacher_id' => $assignment->teacher_id,
                'subject_id' => $assignment->subject_id,
                'grade_id' => $assignment->grade_id,
                'group_id' => $assignment->group_id,
                'academic_year_id' => $newYear->id,
            ])->exists();

            if (!$exists) {
                \App\Models\TeacherSubject::create([
                    'teacher_id' => $assignment->teacher_id,
                    'subject_id' => $assignment->subject_id,
                    'grade_id' => $assignment->grade_id,
                    'group_id' => $assignment->group_id,
                    'academic_year_id' => $newYear->id,
                    'status' => $assignment->status ?? 1
                ]);
            }
        }
    }

    /**
     * 🔥 CREAR PERIODOS
     */
    private function createPeriods($academicYear)
    {
        $totalPeriods = $academicYear->periods;

        $start = Carbon::parse($academicYear->start_date);
        $end   = Carbon::parse($academicYear->end_date);

        $daysPerPeriod = floor($start->diffInDays($end) / $totalPeriods);

        $basePercentage = floor((100 / $totalPeriods) * 100) / 100;
        $totalAssigned = 0;

        for ($i = 1; $i <= $totalPeriods; $i++) {

            $periodStart = $start->copy()->addDays(($i - 1) * $daysPerPeriod);
            $periodEnd   = $start->copy()->addDays(($i * $daysPerPeriod) - 1);

            if ($i == $totalPeriods) {
                $percentage = 100 - $totalAssigned;
            } else {
                $percentage = $basePercentage;
                $totalAssigned += $percentage;
            }

            \App\Models\Period::create([
                'academic_year_id' => $academicYear->id,
                'number' => $i,
                'name' => "Trimestre $i",
                'start_date' => $periodStart,
                'end_date' => $periodEnd,
                'percentage' => $percentage,
                'status' => $i == 1 ? 'activo' : 'cerrado'
            ]);
        }
    }

    /**
     * 🔥 ASIGNAR FECHAS SEGÚN CALENDARIO
     */
    protected static function setDates($academicYear)
    {
        if ($academicYear->calendar === 'A') {

            $academicYear->start_date = Carbon::create($academicYear->year, 1, 1);
            $academicYear->end_date   = Carbon::create($academicYear->year, 12, 31);

        } else {

            $academicYear->start_date = Carbon::create($academicYear->year, 7, 1);
            $academicYear->end_date   = Carbon::create($academicYear->year + 1, 6, 30);
        }
    }

    /**
     * Mostrar
     */
    public function show($id)
    {
        $academicYear = AcademicYear::findOrFail($id);
        return view('admin.academic_years.show', compact('academicYear'));
    }

    /**
     * Eliminar
     */
    public function destroy($id)
    {
        $academicYear = AcademicYear::findOrFail($id);

        if ($academicYear->status === 'activo') {
            return back()->with('error', 'No se puede eliminar un año activo.');
        }

        $academicYear->delete();

        return back()->with('success', 'Eliminado correctamente.');
    }
}