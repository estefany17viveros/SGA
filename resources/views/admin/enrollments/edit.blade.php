@extends('layouts.app')
@section('title', 'Editar Matrícula')
@push('styles')
@vite('resources/css/admin/enrollments/edit.css')
@endpush
@section('content')

<div class="container">

<h2>Editar Matrícula</h2>

<form action="{{ route('admin.enrollments.update',$enrollment->id) }}" method="POST">

@csrf
@method('PUT')

<div class="mb-3">

<label>Grado</label>

<select name="grade_id" class="form-control">

@foreach($grades as $grade)

<option value="{{ $grade->id }}"
{{ $enrollment->grade_id == $grade->id ? 'selected' : '' }}>
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

<option value="{{ $group->id }}"
{{ $enrollment->group_id == $group->id ? 'selected' : '' }}>
{{ $group->name }}
</option>

@endforeach

</select>

</div>

<div class="mb-3">

<label>Estado</label>

<select name="status" class="form-control">

<option value="matriculado">Matriculado</option>
<option value="aprobado">Aprobado</option>
<option value="reprobado">Reprobado</option>
<option value="retirado">Retirado</option>

</select>

</div>

<button class="btn btn-primary">
Actualizar
</button>

<a href="{{ route('admin.enrollments.index') }}"
class="btn btn-secondary">
Volver </a>

</form>

</div>

@endsection
