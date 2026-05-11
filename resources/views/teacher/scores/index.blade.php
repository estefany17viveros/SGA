@extends('layouts.app')
@section('title', 'Registro de Notas')

@push('styles')
    @vite('resources/css/teacher/score/index.css')
@endpush

@section('content')

<div class="container">

    {{-- ===== HEADER ===== --}}
    <div class="header-card d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>📊 Registro de Notas</h2>
            <p class="header-meta">
                <span><strong>Asignatura:</strong> {{ $assignment->subject->name }}</span>
                <span><strong>Grado:</strong> {{ $assignment->grade->name }}</span>
                <span><strong>Trimestre:</strong> {{ $period->name ?? 'Sin trimestre activo' }}</span>
            </p>
        </div>
        <a href="{{ route('teacher.dashboard') }}" class="btn btn-volver">
            ⬅ Volver
        </a>
    </div>

    {{-- ===== BARRA EXCEL ===== --}}
    @if(isset($period))
    <div class="excel-bar mb-3">
        <a href="{{ route('teacher.scores.export', $assignment->id) }}" class="btn btn-excel-download">
            📥 Descargar Plantilla Excel
        </a>

        <form action="{{ route('teacher.scores.import') }}" method="POST"
              enctype="multipart/form-data" class="excel-form">
            @csrf
            <input type="hidden" name="teacher_subject_id" value="{{ $assignment->id }}">
            <input type="hidden" name="period_id"          value="{{ $period->id }}">
            <input type="file" name="file" class="form-control file-input" required>
            <button type="submit" class="btn btn-excel-upload">📤 Subir Excel</button>
        </form>
    </div>
    @endif

    {{-- ===== ALERTAS ===== --}}
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ===== SIN PERIODO ===== --}}
    @if(!isset($period))
        <div class="alert alert-warning">
            ⚠ No hay periodo activo. Contacta al administrador.
        </div>

    @else

    {{-- ===== FORMULARIO ===== --}}
    <form action="{{ route('teacher.scores.store') }}" method="POST">
        @csrf
        <input type="hidden" name="teacher_subject_id" value="{{ $assignment->id }}">
        <input type="hidden" name="period_id"          value="{{ $period->id }}">

        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="tabla-notas">

                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th class="col-nombre">Estudiante</th>
                        <th>Saber <span class="th-pct">33%</span></th>
                        <th>Hacer <span class="th-pct">33%</span></th>
                        <th>Ser <span class="th-pct">33%</span></th>
                        <th>F. Just.</th>
                        <th>F. Injust.</th>
                        <th>Promedio</th>
                        <th>Puesto</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($ranking as $item)
                    @php
                        $student = $item['student'];
                        $score   = $item['score'];
                    @endphp

                    <tr>
                        {{-- # --}}
                        <td class="text-center td-num">{{ $loop->iteration }}</td>

                        {{-- Nombre --}}
                        <td class="td-nombre">{{ $student->full_name }}</td>

                        {{-- Saber --}}
                        <td>
                            <input type="number" step="0.1" min="1" max="5"
                                class="form-control nota"
                                data-id="{{ $student->id }}" data-type="saber"
                                name="scores[{{ $student->id }}][saber]"
                                value="{{ isset($score->saber)
                                    ? number_format(floor($score->saber * 10) / 10, 1, '.', '')
                                    : '' }}">
                        </td>

                        {{-- Hacer --}}
                        <td>
                            <input type="number" step="0.1" min="1" max="5"
                                class="form-control nota"
                                data-id="{{ $student->id }}" data-type="hacer"
                                name="scores[{{ $student->id }}][hacer]"
                                value="{{ isset($score->hacer)
                                    ? number_format(floor($score->hacer * 10) / 10, 1, '.', '')
                                    : '' }}">
                        </td>

                        {{-- Ser --}}
                        <td>
                            <input type="number" step="0.1" min="1" max="5"
                                class="form-control nota"
                                data-id="{{ $student->id }}" data-type="ser"
                                name="scores[{{ $student->id }}][ser]"
                                value="{{ isset($score->ser)
                                    ? number_format(floor($score->ser * 10) / 10, 1, '.', '')
                                    : '' }}">
                        </td>

                        {{-- Faltas justificadas --}}
                        <td>
                            <input type="number" min="0"
                                class="form-control input-ausencia"
                                name="scores[{{ $student->id }}][justified_absences]"
                                value="{{ $score->justified_absences ?? 0 }}">
                        </td>

                        {{-- Faltas injustificadas --}}
                        <td>
                            <input type="number" min="0"
                                class="form-control input-ausencia"
                                name="scores[{{ $student->id }}][unjustified_absences]"
                                value="{{ $score->unjustified_absences ?? 0 }}">
                        </td>

                        {{-- Promedio calculado --}}
                        <td class="text-center">
                            <span class="badge-promedio" id="total-{{ $student->id }}">
                                {{ isset($score->total)
                                    ? number_format(floor($score->total * 10) / 10, 1, '.', '')
                                    : '—' }}
                            </span>
                        </td>

                        {{-- Puesto --}}
                        <td class="text-center">
                            <span class="badge-puesto puesto-{{ $loop->iteration <= 3 ? $loop->iteration : 'resto' }}">
                                {{ $item['position'] }}
                            </span>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="9" class="text-center td-vacio">
                            😕 No hay estudiantes registrados
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>

        <div class="guardar-bar mt-3 text-end">
            <button type="submit" class="btn btn-guardar">
                💾 Guardar Notas
            </button>
        </div>
    </form>

    @endif
</div>

<script>
function truncar(num, dec) {
    return Math.floor(num * Math.pow(10, dec)) / Math.pow(10, dec);
}

function calcularColor(val) {
    if (isNaN(val)) return '';
    if (val >= 4.5) return 'promedio-superior';
    if (val >= 4.0) return 'promedio-alto';
    if (val >= 3.0) return 'promedio-basico';
    return 'promedio-bajo';
}

document.querySelectorAll('.nota').forEach(input => {
    input.addEventListener('input', function () {
        const id    = this.dataset.id;
        const saber = parseFloat(document.querySelector(`[data-id="${id}"][data-type="saber"]`)?.value);
        const hacer = parseFloat(document.querySelector(`[data-id="${id}"][data-type="hacer"]`)?.value);
        const ser   = parseFloat(document.querySelector(`[data-id="${id}"][data-type="ser"]`)?.value);
        const cell  = document.getElementById('total-' + id);

        // Limpiar clases de color
        cell.className = 'badge-promedio';

        if (!isNaN(saber) && !isNaN(hacer) && !isNaN(ser)) {
            const total = truncar((saber + hacer + ser) / 3, 1);
            cell.textContent = total.toFixed(1);
            cell.classList.add(calcularColor(total));
        } else {
            cell.textContent = '—';
        }
    });
});

// Colorear promedios ya cargados al inicio
document.querySelectorAll('.badge-promedio').forEach(cell => {
    const val = parseFloat(cell.textContent);
    if (!isNaN(val)) cell.classList.add(calcularColor(val));
});
</script>

@endsection