@extends('layouts.app')
@push('styles')
@vite('resources/css/admin/teachersubjects/create.css')
@endpush
@section('content')

<div class="container-header">
    <h2>Asignaciones</h2>
    </div>

@if($errors->any())
    <div style="color:red;">
        @foreach($errors->all() as $error)
            <p>• {{ $error }}</p>
        @endforeach
    </div>
@endif

<form action="{{ route('admin.teacher-subjects.store') }}" method="POST">
    @csrf

    <label>Profesor</label>
    <select name="teacher_id">
        <option value="">Seleccione</option>
        @foreach($teachers as $t)
            <option value="{{ $t->id }}">
                {{ $t->first_name }} {{ $t->last_name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <label>Materia</label>
    <select name="subject_id">
        <option value="">Seleccione</option>
        @foreach($subjects as $s)
            <option value="{{ $s->id }}">{{ $s->name }}</option>
        @endforeach
    </select>

    <br><br>

    <label>Grado</label>
    <select name="grade_id">
        <option value="">Seleccione</option>
        @foreach($grades as $g)
            <option value="{{ $g->id }}">{{ $g->name }}</option>
        @endforeach
    </select>

    <br><br>

    <label>Grupo (Opcional)</label>
    <select name="group_id">
        <option value="">Sin grupo</option>
        @foreach($groups as $g)
            <option value="{{ $g->id }}">{{ $g->name }}</option>
        @endforeach
    </select>

   <br><br>

<label>Horas por semana</label>
<div style="display:flex; align-items:center; gap:5px;">
    <input type="number" name="weekly_hours" min="1" max="40" required
           placeholder="Ej: 4"
           style="width:80px;">
    <span><strong>HS</strong></span>
</div>

    <button type="submit">Guardar</button>

</form>

@endsection