@extends('layouts.app')
@push('styles')
@vite('resources/css/admin/teachersubjects/edit.css')
@endpush
@section('content')

<h2>Editar Asignación</h2>

@if($errors->any())
    <div style="color:red;">
        @foreach($errors->all() as $error)
            <p>• {{ $error }}</p>
        @endforeach
    </div>
@endif

<form action="{{ route('admin.teacher-subjects.update', $assignment->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Profesor</label>
    <select name="teacher_id">
        @foreach($teachers as $t)
            <option value="{{ $t->id }}"
                {{ $assignment->teacher_id == $t->id ? 'selected' : '' }}>
                {{ $t->first_name }} {{ $t->last_name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <label>Materia</label>
    <select name="subject_id">
        @foreach($subjects as $s)
            <option value="{{ $s->id }}"
                {{ $assignment->subject_id == $s->id ? 'selected' : '' }}>
                {{ $s->name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <label>Grado</label>
    <select name="grade_id">
        @foreach($grades as $g)
            <option value="{{ $g->id }}"
                {{ $assignment->grade_id == $g->id ? 'selected' : '' }}>
                {{ $g->name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <label>Grupo (Opcional)</label>
    <select name="group_id">
        <option value="">Sin grupo</option>
        @foreach($groups as $g)
            <option value="{{ $g->id }}"
                {{ $assignment->group_id == $g->id ? 'selected' : '' }}>
                {{ $g->name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <label>Estado</label>
    <select name="status">
        <option value="1" {{ $assignment->status ? 'selected' : '' }}>Activo</option>
        <option value="0" {{ !$assignment->status ? 'selected' : '' }}>Inactivo</option>
    </select>

    <br><br>

    <button type="submit">Actualizar</button>

</form>

@endsection