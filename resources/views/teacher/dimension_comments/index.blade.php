@extends('layouts.app')
@section('title', 'Comentarios por Dimensión')

@push('styles')
    @vite('resources/css/teacher/dimension_comments/index.css')
@endpush

@section('content')

<div class="container">

    <h3 class="mb-4">📝 Comentarios por Dimensión</h3>

    {{-- 🔥 FORMULARIO GLOBAL (AÑO + MATERIA + PERIODO) --}}
    <form method="GET" action="{{ route('teacher.dimension_comments.index') }}" class="mb-3">

        {{-- 🔽 AÑO --}}
        <label class="form-label">Seleccionar año</label>
        <select name="academic_year_id" class="form-control mb-2" onchange="this.form.submit()">
            @foreach($years as $y)
                <option value="{{ $y->id }}"
                    {{ $yearId == $y->id ? 'selected' : '' }}>
                    {{ $y->year }} ({{ $y->status }})
                </option>
            @endforeach
        </select>

        {{-- 🔽 MATERIA --}}
        <label class="form-label">Seleccionar materia</label>
        <select name="teacher_subject_id" class="form-control mb-2" onchange="this.form.submit()">
            <option value="">-- Seleccione --</option>

            @foreach($assignments as $a)
                <option value="{{ $a->id }}"
                    {{ request('teacher_subject_id') == $a->id ? 'selected' : '' }}>
                    {{ $a->subject->name }} - {{ $a->grade->name }}
                </option>
            @endforeach
        </select>

        {{-- 🔽 PERÍODO --}}
        <label class="form-label">Seleccionar período</label>
        <select name="period_id" class="form-control" onchange="this.form.submit()">
            <option value="">-- Seleccione período --</option>

            @foreach($periods as $period)
                <option value="{{ $period->id }}"
                    {{ request('period_id') == $period->id ? 'selected' : '' }}>
                    {{ $period->name }}
                </option>
            @endforeach
        </select>

    </form>

    {{-- 🔥 DATOS SELECCIONADOS --}}
    @if($assignment)

        <p class="mb-3">
            <strong>Materia:</strong> {{ $assignment->subject->name }} |
            <strong>Grado:</strong> {{ $assignment->grade->name }} |
            <strong>Año:</strong> {{ $years->where('id', $yearId)->first()->year ?? '' }} |
            <strong>Período:</strong> {{ $selectedPeriod->name ?? 'Sin seleccionar' }}
         </p>

        {{-- ALERTA --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- 🔥 FORMULARIO DE GUARDADO --}}
        <form method="POST" action="{{ route('teacher.dimension_comments.store') }}">
            @csrf

            <input type="hidden" name="teacher_subject_id" value="{{ $assignment->id }}">
            <input type="hidden" name="grade_id" value="{{ $assignment->grade_id }}">
            <input type="hidden" name="period_id" value="{{ request('period_id') }}">
            <input type="hidden" name="academic_year_id" value="{{ $yearId }}">

            <div class="card p-4">

                {{-- SABER --}}
                <div class="mb-3">
                    <label>📊 Saber</label>
                    <textarea name="comments[saber]" class="form-control" rows="3">{{ $comments['saber']->comment ?? '' }}</textarea>
                </div>

                {{-- HACER --}}
                <div class="mb-3">
                    <label>🛠 Hacer</label>
                    <textarea name="comments[hacer]" class="form-control" rows="3">{{ $comments['hacer']->comment ?? '' }}</textarea>
                </div>

                {{-- SER --}}
                <div class="mb-3">
                    <label>🤝 Ser</label>
                    <textarea name="comments[ser]" class="form-control" rows="3">{{ $comments['ser']->comment ?? '' }}</textarea>
                </div>

            </div>

            <div class="mt-3 text-end">
                <button class="btn btn-primary">
                    💾 Guardar
                </button>
            </div>

        </form>

    @endif

</div>

@endsection