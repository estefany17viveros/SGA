@extends('layouts.app')
@section('title', 'Registro de Notas')

@push('styles')
    @vite('resources/css/teacher/score/index.css')
@endpush

@section('content')

<div class="container">

    {{-- 🔥 HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>📊 Registro de Notas</h2>
            <p class="mb-0">
                <strong>Asignatura:</strong> {{ $assignment->subject->name }} |
                <strong>Grado:</strong> {{ $assignment->grade->name }} |
                <strong>Trimestre:</strong> {{ $period->name ?? 'Sin trimestre activo' }}
            </p>
        </div>

        <a href="{{ route('teacher.dashboard') }}" class="btn btn-secondary">
            ⬅ Volver
        </a>
    </div>

    {{-- 🔥 BOTONES EXCEL --}}
    @if(isset($period))
    <div class="mb-3 d-flex gap-2">

        {{-- 📥 Descargar --}}
        <a href="{{ route('teacher.scores.export', $assignment->id) }}" class="btn btn-success">
            📥 Descargar Plantilla Excel
        </a>

        {{-- 📤 Subir --}}
        <form action="{{ route('teacher.scores.import') }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2">
            @csrf

            <input type="hidden" name="teacher_subject_id" value="{{ $assignment->id }}">
            <input type="hidden" name="period_id" value="{{ $period->id }}">

            <input type="file" name="file" class="form-control" required>

            <button type="submit" class="btn btn-primary">
                📤 Subir Excel
            </button>
        </form>

    </div>
    @endif

    {{-- 🚨 ERROR --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- ✅ SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ❌ SIN PERIODO --}}
    @if(!isset($period))
        <div class="alert alert-warning">
            ⚠ No hay periodo activo. Contacta al administrador.
        </div>
    @else

    {{-- 📥 FORM --}}
    <form action="{{ route('teacher.scores.store') }}" method="POST">
        @csrf

        <input type="hidden" name="teacher_subject_id" value="{{ $assignment->id }}">
        <input type="hidden" name="period_id" value="{{ $period->id }}">

        <div class="table-responsive">
            <table class="table table-bordered table-striped">

                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Estudiante</th>
                        <th>Saber (33%)</th>
                        <th>Hacer (33%)</th>
                        <th>Ser (33%)</th>
                        <th>Promedio</th>
                        <th>Puesto</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                    function nota($n) {
                        return $n !== null 
                            ? rtrim(rtrim(number_format($n, 2, '.', ''), '0'), '.') 
                            : '';
                    }
                    @endphp

                    @forelse($ranking as $item)

                        @php
                            $student = $item['student'];
                            $score   = $item['score'];
                        @endphp

                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>

                            <td>{{ $student->full_name }}</td>

                            {{-- SABER --}}
                            <td>
                                <input type="number"
                                    step="0.01"
                                    min="1"
                                    max="5"
                                    class="form-control nota"
                                    data-id="{{ $student->id }}"
                                    data-type="saber"
                                    name="scores[{{ $student->id }}][saber]"
                                    value="{{ isset($score->saber) ? number_format($score->saber, 2, '.', '') : '' }}">
                            </td>

                            {{-- HACER --}}
                            <td>
                                <input type="number"
                                    step="0.01"
                                    min="1"
                                    max="5"
                                    class="form-control nota"
                                    data-id="{{ $student->id }}"
                                    data-type="hacer"
                                    name="scores[{{ $student->id }}][hacer]"
                                    value="{{ isset($score->hacer) ? number_format($score->hacer, 2, '.', '') : '' }}">
                            </td>

                            {{-- SER --}}
                            <td>
                                <input type="number"
                                    step="0.01"
                                    min="1"
                                    max="5"
                                    class="form-control nota"
                                    data-id="{{ $student->id }}"
                                    data-type="ser"
                                    name="scores[{{ $student->id }}][ser]"
                                    value="{{ isset($score->ser) ? number_format($score->ser, 2, '.', '') : '' }}">
                            </td>

                            {{-- PROMEDIO --}}
                            <td class="text-center">
                                <strong id="total-{{ $student->id }}">
                                    {{ isset($score->total) ? number_format($score->total, 2, '.', '') : '-' }}
                                </strong>
                            </td>

                            {{-- PUESTO --}}
                            <td class="text-center">
                                <span class="badge bg-warning text-dark">
                                    {{ $item['position'] }}
                                </span>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center">
                                No hay estudiantes registrados
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

        {{-- BOTÓN --}}
        <div class="mt-3 text-end">
            <button class="btn btn-primary">
                💾 Guardar Notas
            </button>
        </div>

    </form>

    @endif

</div>

{{-- 🔥 SCRIPT --}}
<script>
function truncateDecimals(num, decimals) {
    let factor = Math.pow(10, decimals);
    return Math.floor(num * factor) / factor;
}

document.querySelectorAll('.nota').forEach(input => {

    input.addEventListener('input', function () {

        let id = this.dataset.id;

        let saber = parseFloat(document.querySelector(`[data-id="${id}"][data-type="saber"]`)?.value);
        let hacer = parseFloat(document.querySelector(`[data-id="${id}"][data-type="hacer"]`)?.value);
        let ser   = parseFloat(document.querySelector(`[data-id="${id}"][data-type="ser"]`)?.value);

        let totalCell = document.getElementById('total-' + id);

        if (!isNaN(saber) && !isNaN(hacer) && !isNaN(ser)) {

            let total = (saber + hacer + ser) / 3;
            let totalTruncado = truncateDecimals(total, 2);

            totalCell.innerText = totalTruncado.toFixed(2);

        } else {
            totalCell.innerText = '-';
        }

    });

});
</script>

@endsection
 