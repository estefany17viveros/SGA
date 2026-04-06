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
    $academicYears = AcademicYear::orderBy('year', 'desc')
        ->paginate(10);

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
     * Guardar nuevo año académico + clonación + promoción
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

            // Año activo actual
            $oldYear = AcademicYear::where('status', 'activo')->first();

            // Crear nuevo año
            $newYear = AcademicYear::create([
                'year' => $request->year,
                'calendar' => $request->calendar,
                'periods' => $request->periods,
            ]);

              // 🔥 AQUI VA ESTO (CREA LOS PERIODOS)
        $this->createPeriods($newYear);

            // Clonar estructura y promover estudiantes
            if ($oldYear) {
                 $this->promoteStudents($oldYear, $newYear);
            }

            DB::commit();

            return redirect()->route('admin.academic_years.index')
                ->with('success', 'Año académico creado, activado y estudiantes promovidos correctamente.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', 'Error al crear el año académico: ' . $e->getMessage());
        }
    }

    /**
     * Promover estudiantes aprobados al siguiente grado
     */
    private function promoteStudents($oldYear, $newYear)
{
    $enrollments = Enrollment::where('academic_year_id', $oldYear->id)
        ->where('status', 'aprobado')
        ->with('grade')
        ->get();

    foreach ($enrollments as $enrollment) {

       $nextGrade = Grade::where('level', $enrollment->grade->level + 1)->first();

        if ($nextGrade) {

            $exists = Enrollment::where('student_id', $enrollment->student_id)
                ->where('academic_year_id', $newYear->id)
                ->exists();

            if (!$exists) {

                Enrollment::create([
                    'student_id' => $enrollment->student_id,
                    'grade_id' => $nextGrade->id,
                    'academic_year_id' => $newYear->id,
                    'group_id' => null,
                    'status' => 'matriculado'
                ]);
            }
        }
    }

    }
  private function createPeriods($academicYear)
{
    $totalPeriods = $academicYear->periods;

    $start = \Carbon\Carbon::parse($academicYear->start_date);
    $end   = \Carbon\Carbon::parse($academicYear->end_date);

    $daysPerPeriod = floor($start->diffInDays($end) / $totalPeriods);

    // 🔥 dividir porcentaje
    $basePercentage = floor((100 / $totalPeriods) * 100) / 100; // 2 decimales
    $totalAssigned = 0;

    for ($i = 1; $i <= $totalPeriods; $i++) {

        $periodStart = $start->copy()->addDays(($i - 1) * $daysPerPeriod);
        $periodEnd   = $start->copy()->addDays(($i * $daysPerPeriod) - 1);

        // 🔥 último periodo ajusta sobrante
        if ($i == $totalPeriods) {
            $percentage = 100 - $totalAssigned;
        } else {
            $percentage = $basePercentage;
            $totalAssigned += $percentage;
        }

        \App\Models\Period::create([
            'academic_year_id' => $academicYear->id,
            'number' => $i,
            'name' => "Periodo $i",
            'start_date' => $periodStart,
            'end_date' => $periodEnd,
            'percentage' => $percentage,
            'status' => $i == 1 ? 'activo' : 'cerrado'
        ]);
    }
}
    /**
     * Cerrar año académico
     */
    public function close($id)
    {
        $year = AcademicYear::findOrFail($id);

        if ($year->status === 'cerrado') {
            return back()->with('error', 'El año ya está cerrado.');
        }

        $year->update(['status' => 'cerrado']);

        return back()->with('success', 'Año académico cerrado correctamente.');
    }

    /**
     * Mostrar
     */
    public function show($id)
    {
        $academicYear = AcademicYear::findOrFail($id);
        return view('admin.academic_years.show', compact('academicYear'));
    }

// no lleva la funcion edit para no dañar el sistema completo ni año ni periodo ni calendario
    /**
     * Eliminar
     */
    public function destroy($id)
    {
        $academicYear = AcademicYear::findOrFail($id);

        if ($academicYear->status === 'activo') {
            return redirect()->route('admin.academic_years.index')
                ->with('error', 'No se puede eliminar un año académico activo.');
        }

        $academicYear->delete();

        return redirect()->route('admin.academic_years.index')
            ->with('success', 'Año académico eliminado correctamente.');
    }

    /**
     * Asignar fechas según calendario
     */
    protected static function setDates($academicYear)
    {
        if ($academicYear->calendar === 'A') {

            $academicYear->start_date = Carbon::create($academicYear->year, 1, 1);
            $academicYear->end_date   = Carbon::create($academicYear->year, 12, 31);

        } elseif ($academicYear->calendar === 'B') {

            $academicYear->start_date = Carbon::create($academicYear->year, 7, 1);
            $academicYear->end_date   = Carbon::create($academicYear->year + 1, 6, 30);
        }
    }
}