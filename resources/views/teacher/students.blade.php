@extends('layouts.app')

@push('styles')
@vite('resources/css/teacher/students.css')
@endpush

@section('content')

<div class="container">

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>👨‍🎓 Estudiantes</h2>

    <a href="{{ route('teacher.scores.index', $teacher_subject_id) }}" class="btn btn-primary">
        📊 Gestionar Notas
    </a>
</div>

<a href="{{ route('teacher.dashboard') }}">⬅ Volver al inicio</a>

@php
    use App\Models\AcademicYear;
    use App\Models\Period;

    $year = AcademicYear::where('status', 'activo')->first();

    $periods = [];

    if ($year) {
        $periods = Period::where('academic_year_id', $year->id)
            ->orderBy('id')
            ->pluck('id')
            ->toArray();
    }

    if (empty($periods)) {
        $periods = [1,2,3,4];
    }

    // 🔥 ORDENAR POR PROMEDIO (TRUNCADO)
    $studentsSorted = $students->sortByDesc(function($student) use ($teacher_subject_id, $periods) {

        $total = 0;
        $count = 0;

        foreach ($periods as $period) {
            $score = $student->scores
                ->where('teacher_subject_id', $teacher_subject_id)
                ->where('period_id', $period)
                ->first();

            if ($score && $score->total !== null) {
                $total += $score->total;
                $count++;
            }
        }

        return $count > 0 
            ? floor(($total / $count) * 100) / 100 
            : 0;
    })->values();
@endphp

<div class="table-responsive mt-3">
    <table class="table table-bordered">

        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nombre</th>

                @foreach($periods as $period)
                    <th>P{{ $period }}</th>
                @endforeach

                <th>Total Materia</th>
                <th>Puesto</th>
            </tr>
        </thead>

        <tbody>

            @forelse($studentsSorted as $student)

                @php
                    $student->loadMissing('scores');

                    $totalFinal = 0;
                    $count = 0;
                    $periodTotals = [];

                    foreach ($periods as $period) {

                        $score = $student->scores
                            ->where('teacher_subject_id', $teacher_subject_id)
                            ->where('period_id', $period)
                            ->first();

                        $value = $score->total ?? null;

                        if (!is_null($value)) {
                            $totalFinal += $value;
                            $count++;
                        }

                        $periodTotals[$period] = $value;
                    }

                    // 🔥 PROMEDIO FINAL TRUNCADO
                    $averageFinal = $count > 0 
                        ? floor(($totalFinal / $count) * 100) / 100 
                        : 0;

                    // 🔥 CALCULAR PUESTO (USANDO TRUNCADO)
                    $position = 1;

                    foreach ($studentsSorted as $index => $s) {

                        $sTotal = 0;
                        $sCount = 0;

                        foreach ($periods as $p) {
                            $sc = $s->scores
                                ->where('teacher_subject_id', $teacher_subject_id)
                                ->where('period_id', $p)
                                ->first();

                            if ($sc && $sc->total !== null) {
                                $sTotal += $sc->total;
                                $sCount++;
                            }
                        }

                        $sAvg = $sCount > 0 
                            ? floor(($sTotal / $sCount) * 100) / 100 
                            : 0;

                        if ($index > 0) {
                            $prev = $studentsSorted[$index - 1];

                            $prevTotal = 0;
                            $prevCount = 0;

                            foreach ($periods as $p) {
                                $psc = $prev->scores
                                    ->where('teacher_subject_id', $teacher_subject_id)
                                    ->where('period_id', $p)
                                    ->first();

                                if ($psc && $psc->total !== null) {
                                    $prevTotal += $psc->total;
                                    $prevCount++;
                                }
                            }

                            $prevAvg = $prevCount > 0 
                                ? floor(($prevTotal / $prevCount) * 100) / 100 
                                : 0;

                            if ($sAvg != $prevAvg) {
                                $position = $index + 1;
                            }
                        }

                        if ($s->id == $student->id) {
                            break;
                        }
                    }
                @endphp

                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $student->full_name }}</td>

                    {{-- 🔥 NOTAS POR PERIODO (TRUNCADAS Y FORMATEADAS) --}}
                    @foreach($periods as $period)
                        <td class="text-center">
                            <span class="badge bg-secondary">
                                {{ isset($periodTotals[$period]) 
                                    ? number_format(floor($periodTotals[$period] * 100) / 100, 2, '.', '') 
                                    : '-' }}
                            </span>
                        </td>
                    @endforeach

                    {{-- 🔥 PROMEDIO FINAL --}}
                    <td class="text-center">
                        <span class="badge bg-success">
                            {{ number_format($averageFinal, 2, '.', '') }}
                        </span>
                    </td>

                    {{-- 🔥 PUESTO --}}
                    <td class="text-center">
                        <span class="badge bg-warning text-dark">
                            {{ $position }}
                        </span>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="{{ count($periods) + 4 }}" class="text-center">
                        No hay estudiantes
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>
</div>

</div>

@endsection