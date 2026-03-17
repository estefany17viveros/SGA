@extends('layouts.app')
@section('title', 'Gestión de Matrículas')

@push('styles')
@vite('resources/css/enrollments/index.css')
@endpush

@section('content')

<div class="container">

<h2>Gestión de Matrículas</h2>

<a href="{{ route('admin.enrollments.create') }}" class="btn btn-primary mb-3">
Nueva Matrícula
</a>

{{-- MENSAJES DEL SISTEMA --}}
@if(session('success'))

<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

@if(session('error'))

<div class="alert alert-danger">
{{ session('error') }}
</div>
@endif

<form method="GET" class="mb-3">

<select name="grade_id" onchange="this.form.submit()" class="form-control">

<option value="">Todos los grados</option>

@foreach($grades as $grade)

<option value="{{ $grade->id }}"
{{ request('grade_id') == $grade->id ? 'selected' : '' }}>

Grado {{ $grade->name }}

</option>

@endforeach

</select>

</form>

<table class="table table-bordered">

<thead>

<tr>
<th>Estudiante</th>
<th>Año</th>
<th>Grado</th>
<th>Grupo</th>
<th>Estado</th>
<th>Acciones</th>
</tr>

</thead>

<tbody>

@forelse($enrollments as $enrollment)

<tr>

<td>
{{ $enrollment->student->first_name ?? '' }}
{{ $enrollment->student->last_name ?? '' }}
</td>

<td>
{{ $enrollment->academicYear->year ?? '' }}
</td>

<td>
{{ $enrollment->grade->name ?? '' }}
</td>

<td>
{{ $enrollment->group->name ?? 'Sin grupo' }}
</td>

<td>

<form action="{{ route('admin.enrollments.updateStatus',$enrollment->id) }}" method="POST">

@csrf
@method('PUT')

<select name="status" onchange="this.form.submit()" class="form-control">

<option value="matriculado" {{ $enrollment->status=='matriculado'?'selected':'' }}>
Matriculado
</option>

<option value="aprobado" {{ $enrollment->status=='aprobado'?'selected':'' }}>
Aprobado
</option>

<option value="reprobado" {{ $enrollment->status=='reprobado'?'selected':'' }}>
Reprobado
</option>

<option value="retirado" {{ $enrollment->status=='retirado'?'selected':'' }}>
Retirado
</option>

</select>

</form>

</td>

<td>

<a href="{{ route('admin.enrollments.show',$enrollment->id) }}" class="btn btn-info btn-sm">
Ver
</a>

<a href="{{ route('admin.enrollments.edit',$enrollment->id) }}" class="btn btn-warning btn-sm">
Editar
</a>

<form action="{{ route('admin.enrollments.destroy',$enrollment->id) }}" method="POST" style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">
Eliminar
</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="6">No hay matrículas registradas</td>
</tr>

@endforelse

</tbody>

</table>

</div>

@endsection
