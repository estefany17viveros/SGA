@extends('layouts.app')
@section('title', 'Comentarios por Dimensión')
@push('styles')
   @vite(['resources/css/teacher/dimension_comments/index.css'])
@endpush
@section('content')

<div class="container">

    <h3>📝 Comentarios por Dimensión</h3>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul style="margin:0;padding-left:18px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    {{-- ===== FILTROS ===== --}}
    <form method="GET" action="{{ route('teacher.dimension_comments.index') }}" class="filtros-form">

        <div class="filtro-grupo">
            <label>Año</label>
            <select name="academic_year_id" onchange="this.form.submit()">
                @foreach($years as $y)
                    <option value="{{ $y->id }}" {{ $yearId == $y->id ? 'selected' : '' }}>
                        {{ $y->year }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="filtro-grupo">
            <label>Materia</label>
            <select name="teacher_subject_id" onchange="this.form.submit()">
                <option value="">-- Seleccione --</option>

                {{-- 🔥 DISCIPLINA --}}
                <option value="discipline_all"
                    {{ request('teacher_subject_id') == 'discipline_all' ? 'selected' : '' }}>
                    🚨 Disciplina
                </option>

                {{-- MATERIAS NORMALES --}}
                @foreach($assignments as $a)
                    @if($a->id !== 'discipline_all')
                        <option value="{{ $a->id }}"
                            {{ request('teacher_subject_id') == $a->id ? 'selected' : '' }}>
                            {{ $a->subject->name ?? '' }} - {{ $a->grade->name ?? '' }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="filtro-grupo">
            <label>Periodo</label>
            <select name="period_id" onchange="this.form.submit()">
                @foreach($periods as $p)
                    <option value="{{ $p->id }}" {{ request('period_id') == $p->id ? 'selected' : '' }}>
                        {{ $p->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn-filtrar">🔍 Filtrar</button>

    </form>

    {{-- ===== FORMULARIO COMENTARIOS ===== --}}
    @if($assignment && request('period_id'))

        <form method="POST" action="{{ route('teacher.dimension_comments.store') }}" class="form-comentarios">
            @csrf

            <input type="hidden" name="teacher_subject_id" value="{{ $assignment->id }}">
            @if(!$isDiscipline)
                <input type="hidden" name="grade_id" value="{{ $assignment->grade_id }}">
            @endif
            <input type="hidden" name="period_id" value="{{ request('period_id') }}">
            <input type="hidden" name="academic_year_id" value="{{ $yearId }}">

            {{-- ===== SOLO DISCIPLINA ===== --}}
            @if($isDiscipline)

                <div class="dimensiones-grid disciplina-solo">
                    <div class="dimension-card disciplina">
                        <div class="dimension-header">
                            <span class="dimension-icon">🚨</span>
                            <span class="dimension-title">Disciplina</span>
                        </div>
                        <textarea name="comments[disciplina]" class="form-control" rows="8"
                            placeholder="Escribe el comentario de disciplina...">{{ $comments['disciplina']->comment ?? '' }}</textarea>
                    </div>
                </div>

            {{-- ===== TRES DIMENSIONES ===== --}}
            @else

                <div class="dimensiones-grid">

                    <div class="dimension-card saber">
                        <div class="dimension-header">
                            <span class="dimension-icon">📘</span>
                            <span class="dimension-title">Saber</span>
                        </div>
                        <textarea name="comments[saber]" class="form-control" rows="7"
                            placeholder="Comentario sobre el saber...">{{ trim($comments['saber']->comment ?? '') }}</textarea>
                    </div>

                    <div class="dimension-card hacer">
                        <div class="dimension-header">
                            <span class="dimension-icon">🛠</span>
                            <span class="dimension-title">Hacer</span>
                        </div>
                        <textarea name="comments[hacer]" class="form-control" rows="7"
                            placeholder="Comentario sobre el hacer...">{{ trim($comments['hacer']->comment ?? '') }}</textarea>
                    </div>

                    <div class="dimension-card ser">
                        <div class="dimension-header">
                            <span class="dimension-icon">🤝</span>
                            <span class="dimension-title">Ser</span>
                        </div>
                        <textarea name="comments[ser]" class="form-control" rows="7"
                            placeholder="Comentario sobre el ser...">{{ trim($comments['ser']->comment ?? '') }}</textarea>
                    </div>

                </div>

            @endif

            <div class="form-footer">
                <button type="submit" class="btn-guardar">💾 Guardar Comentarios</button>
            </div>

        </form>

    @endif

</div>

@endsection