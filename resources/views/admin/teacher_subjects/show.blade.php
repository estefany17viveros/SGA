@extends('layouts.app')
@push('styles')
@vite('resources/css/admin/teachersubjects/show.css')
@endpush
@section('content')

<h2>Detalle de Asignación</h2>

<p><strong>Profesor:</strong> {{ $assignment->teacher->first_name }} {{ $assignment->teacher->last_name }}</p>
<p><strong>Materia:</strong> {{ $assignment->subject->name }}</p>
<p><strong>Grado:</strong> {{ $assignment->grade->name }}</p>
<p><strong>Grupo:</strong> {{ $assignment->group ? $assignment->group->name : 'General' }}</p>
<p><strong>Año:</strong> {{ $assignment->academicYear->year }}</p>
<p><strong>Estado:</strong> {{ $assignment->status ? 'Activo' : 'Inactivo' }}</p>

<a href="{{ route('admin.teacher-subjects.index') }}">Volver</a>

@endsection