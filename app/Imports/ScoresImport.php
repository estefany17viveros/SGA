<?php

namespace App\Imports;

use App\Models\Score;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ScoresImport implements ToCollection, WithHeadingRow
{
    protected $teacher_subject_id;
    protected $period_id;

    public function __construct($teacher_subject_id, $period_id)
    {
        $this->teacher_subject_id = $teacher_subject_id;
        $this->period_id = $period_id;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            // 🔥 CONVERTIR TODO A ARRAY NORMAL
            $row = collect($row)->mapWithKeys(function ($value, $key) {

                // limpiar encabezados
                $cleanKey = Str::of($key)
                    ->lower()
                    ->replace(' ', '_')
                    ->replace('-', '_')
                    ->replace('.', '')
                    ->toString();

                return [$cleanKey => $value];
            });

            // 🔥 DEBUG
            // dd($row);

            $studentId = $row['id'] ?? null;

            // 🔥 LEER COLUMNAS
            $saber = $row['saber'] ?? null;
            $hacer = $row['hacer'] ?? null;
            $ser   = $row['ser'] ?? null;

            // 🔥 SI NO HAY ID -> IGNORAR
            if (!$studentId) {
                continue;
            }

            // 🔥 LIMPIAR VACÍOS
            $saber = ($saber !== '') ? $saber : null;
            $hacer = ($hacer !== '') ? $hacer : null;
            $ser   = ($ser !== '') ? $ser : null;

            // 🔥 ARMAR ARRAY DE NOTAS EXISTENTES
            $notas = [];

            if ($saber !== null && is_numeric($saber)) {
                $notas[] = floatval($saber);
            }

            if ($hacer !== null && is_numeric($hacer)) {
                $notas[] = floatval($hacer);
            }

            if ($ser !== null && is_numeric($ser)) {
                $notas[] = floatval($ser);
            }

            // 🔥 CALCULAR PROMEDIO
            $total = null;

            if (count($notas) > 0) {

                $total = array_sum($notas) / count($notas);

                // 🔥 TRUNCAR
                $total = floor($total * 100) / 100;
            }

            // 🔥 GUARDAR
            Score::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'teacher_subject_id' => $this->teacher_subject_id,
                    'period_id' => $this->period_id,
                ],
                [
                    'saber' => $saber,
                    'hacer' => $hacer,
                    'ser'   => $ser,
                    'total' => $total,
                ]
            );
        }
    }
}