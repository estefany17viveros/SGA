@extends('layouts.app')

@section('content')

<h1>Detalle de Asignación</h1>

<p><strong>Grado:</strong> {{ $academicAssignment->grade->name }}</p>
<p><strong>Grupo:</strong> {{ $academicAssignment->group->name }}</p>
<p><strong>Materia:</strong> {{ $academicAssignment->subject->name }}</p>
<p><strong>Año:</strong> {{ $academicAssignment->academicYear->name ?? '' }}</p>

<a href="{{ route('academic-assignments.index') }}">Volver</a>

@endsection