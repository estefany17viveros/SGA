@extends('layouts.app')
@section('title', 'Crear Matrícula')

@push('styles')
@vite('resources/css/enrollments/create.css')
@endpush

@section('content')

<div class="container">

<h2>Crear Matrícula</h2>

{{-- ERRORES DE VALIDACIÓN --}}
@if ($errors->any())

<div class="alert alert-danger">
<strong>Se encontraron errores:</strong>
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

{{-- MENSAJES DEL SISTEMA --}}
@if(session('error'))

<div class="alert alert-danger">
{{ session('error') }}
</div>
@endif

@if(session('success'))

<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

<form action="{{ route('admin.enrollments.store') }}" method="POST">

@csrf

<div class="mb-3">
<label>Estudiante</label>

<select name="student_id" class="form-control">

@foreach($students as $student)

<option value="{{ $student->id }}">
{{ $student->first_name }} {{ $student->last_name }}
</option>

@endforeach

</select>
</div>

<div class="mb-3">
<label>Grado</label>

<select name="grade_id" class="form-control">

@foreach($grades as $grade)

<option value="{{ $grade->id }}">
{{ $grade->name }}
</option>

@endforeach

</select>
</div>

<div class="mb-3">
<label>Grupo</label>

<select name="group_id" class="form-control">

<option value="">Sin grupo</option>

@foreach($groups as $group)

<option value="{{ $group->id }}">
{{ $group->name }}
</option>

@endforeach

</select>
</div>

<button class="btn btn-success">
Guardar Matrícula
</button>

<a href="{{ route('admin.enrollments.index') }}"
class="btn btn-secondary">
Cancelar </a>

</form>

</div>

@endsection
