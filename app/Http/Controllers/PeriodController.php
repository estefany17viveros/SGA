<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

use Carbon\Carbon;
class PeriodController extends Controller
{
    /**
     * 📋 Listar periodos
     */
    public function index($yearId)
{
    $this->updateStatusByDate(); // 👈 AQUÍ

    $year = AcademicYear::findOrFail($yearId);

    $periods = Period::where('academic_year_id', $yearId)
        ->orderBy('number')
        ->get();

    return view('admin.periods.index', compact('periods', 'year'));
}

public function updateStatusByDate()
{
    $today = Carbon::today();

    // 🔥 Buscar si hay uno activo (por botón o lo que sea)
    $active = Period::where('status', 'activo')->first();

    if ($active) {

        // 🔥 Si HOY está dentro de su rango → normal (no tocar)
        if ($today->between($active->start_date, $active->end_date)) {
            return;
        }

        // 🔥 Si NO está en fechas, solo respetarlo por HOY
        // usamos updated_at como referencia
        $lastUpdate = Carbon::parse($active->updated_at);

        if ($lastUpdate->isToday()) {
            return; // 👈 botón válido SOLO hoy
        }

        // 🔄 ya pasó el día → se libera control automático
    }

    // 🔥 CONTROL AUTOMÁTICO POR FECHAS
    $periods = Period::all();

    foreach ($periods as $period) {

        if ($today->between($period->start_date, $period->end_date)) {
            $period->update(['status' => 'activo']);
        } else {
            $period->update(['status' => 'cerrado']);
        }
    }
}
    /**
     * ✏️ Editar periodo (SIN porcentaje)
     */
    public function edit($id)
    {
        $period = Period::findOrFail($id);

        return view('admin.periods.edit', compact('period'));
    }

    /**
     * 🔄 Actualizar (SIN percentage)
     */
    public function update(Request $request, $id)
{
    $period = Period::findOrFail($id);

    $data = $request->validate([
        'name' => 'required|string|max:255',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'percentage' => 'required|numeric|min:0|max:100',
    ]);

    $period->update($data);

    return redirect()->route('admin.periods.index', $period->academic_year_id)
        ->with('success', 'Trimestre actualizado correctamente');
}

    /**
     * 🔒 Cerrar
     */
    public function close($id)
    {
        $period = Period::findOrFail($id);

        if ($period->status === 'cerrado') {
            return back()->with('error', 'Ya está cerrado');
        }

        $period->update(['status' => 'cerrado']);

        return redirect()->route('admin.periods.index', $period->academic_year_id)
            ->with('success', 'Trimestre cerrado');
    }

    /**
     * 🔓 Activar
     */
    public function open($id)
    {
        $period = Period::findOrFail($id);

        Period::where('academic_year_id', $period->academic_year_id)
            ->update(['status' => 'cerrado']);

        $period->update(['status' => 'activo']);

        return redirect()->route('admin.periods.index', $period->academic_year_id)
            ->with('success', 'Trimestre activado');
    }

    /**
     * 👁️ Ver
     */
    public function show($id)
    {
        $period = Period::findOrFail($id);

        return view('admin.periods.show', compact('period'));
    }

    /**
     * ❌ Eliminar
     */
    public function destroy($id)
    {
        $period = Period::findOrFail($id);

        if ($period->status === 'activo') {
            return back()->with('error', 'No puedes eliminar un trimestre activo');
        }

        $yearId = $period->academic_year_id;

        $period->delete();

        return redirect()->route('admin.periods.index', $yearId)
            ->with('success', 'Trimestre eliminado correctamente');
    }
}