@extends('layouts.app')
@push('styles')
@vite('resources/css/admin/teachersubjects/create.css')
@endpush
@section('content')

<h2>Nueva Asignación</h2>

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

    <button type="submit">Guardar</button>

</form>

@endsection