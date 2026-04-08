@extends('layouts.app')
@section('title', 'Crear Matrícula')

@push('styles')
@vite('resources/css/admin/enrollments/create.css')
@endpush

@section('content')

<div class="container">

<h2>Crear Matrícula</h2>

{{-- ERRORES --}}
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

{{-- MENSAJES --}}
@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('admin.enrollments.store') }}" method="POST">
@csrf

{{-- 🔥 ESTUDIANTE --}}
<div class="mb-3">
<label>Estudiante</label>

@if(isset($student))
    {{-- 🔒 AUTOMÁTICO --}}
    <input type="hidden" name="student_id" value="{{ $student->id }}">

    <div class="alert alert-info">
        Matriculando a:
        <strong>{{ $student->first_name }} {{ $student->last_name }}</strong>
    </div>
@else
    {{-- 🧑‍💻 MANUAL --}}
    <select name="student_id" class="form-control" required>
        <option value="">Seleccione</option>

        @foreach(($students ?? []) as $s)
        <option value="{{ $s->id }}"
            {{ old('student_id') == $s->id ? 'selected' : '' }}>
            {{ $s->first_name }} {{ $s->last_name }}
        </option>
        @endforeach

    </select>
@endif

</div>

{{-- 📚 GRADO --}}
<div class="mb-3">
<label>Grado</label>

<select name="grade_id" class="form-control" required>
<option value="">Seleccione</option>

@foreach(($grades ?? []) as $grade)
<option value="{{ $grade->id }}"
    {{ old('grade_id') == $grade->id ? 'selected' : '' }}>
    {{ $grade->name }}
</option>
@endforeach

</select>
</div>

{{-- 👥 GRUPO --}}
<div class="mb-3">
<label>Grupo</label>

<select name="group_id" class="form-control">
<option value="">Sin grupo</option>

@foreach(($groups ?? []) as $group)
<option value="{{ $group->id }}"
    {{ old('group_id') == $group->id ? 'selected' : '' }}>
    {{ $group->name }}
</option>
@endforeach

</select>
</div>

{{-- BOTONES --}}
<button class="btn btn-success">
Guardar Matrícula
</button>

<a href="{{ route('admin.enrollments.index') }}" class="btn btn-secondary">
Cancelar
</a>

</form>

</div>

@endsection