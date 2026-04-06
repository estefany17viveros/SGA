@extends('layouts.app')

@section('content')

<h1>Editar Asignación</h1>

<form method="POST" action="{{ route('academic-assignments.update', $academicAssignment) }}">
    @csrf
    @method('PUT')

    <select name="grade_id">
        @foreach($grades as $g)
            <option value="{{ $g->id }}" {{ $academicAssignment->grade_id == $g->id ? 'selected' : '' }}>
                {{ $g->name }}
            </option>
        @endforeach
    </select>

    <select name="group_id">
        @foreach($groups as $g)
            <option value="{{ $g->id }}" {{ $academicAssignment->group_id == $g->id ? 'selected' : '' }}>
                {{ $g->name }}
            </option>
        @endforeach
    </select>

    <select name="subject_id">
        @foreach($subjects as $s)
            <option value="{{ $s->id }}" {{ $academicAssignment->subject_id == $s->id ? 'selected' : '' }}>
                {{ $s->name }}
            </option>
        @endforeach
    </select>

    <select name="academic_year_id">
        @foreach($years as $y)
            <option value="{{ $y->id }}" {{ $academicAssignment->academic_year_id == $y->id ? 'selected' : '' }}>
                {{ $y->name }}
            </option>
        @endforeach
    </select>

    <button>Actualizar</button>

</form>

@endsection