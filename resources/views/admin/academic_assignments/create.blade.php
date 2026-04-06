@extends('layouts.app')

@section('content')

<h1>Crear Asignación</h1>

<form method="POST" action="{{ route('academic-assignments.store') }}">
    @csrf

    <select name="grade_id">
        <option>Seleccione grado</option>
        @foreach($grades as $g)
            <option value="{{ $g->id }}">{{ $g->name }}</option>
        @endforeach
    </select>

    <select name="group_id">
        <option>Seleccione grupo</option>
        @foreach($groups as $g)
            <option value="{{ $g->id }}">{{ $g->name }}</option>
        @endforeach
    </select>

    <select name="subject_id">
        <option>Seleccione materia</option>
        @foreach($subjects as $s)
            <option value="{{ $s->id }}">{{ $s->name }}</option>
        @endforeach
    </select>

    <select name="academic_year_id">
        <option>Seleccione año</option>
        @foreach($years as $y)
            <option value="{{ $y->id }}">{{ $y->name }}</option>
        @endforeach
    </select>

    <button>Guardar</button>

</form>

@endsection