@extends('layouts.app')
@section('title', 'Detalle de Matrícula')
@push('styles')
@vite('resources/css/enrollments/show.css')
@endpush

@section('content')

<div class="container">

<h2>Detalle de Matrícula</h2>

<div class="card">
<div class="card-body">

<p>
<strong>Estudiante:</strong>
{{ $enrollment->student->first_name }}
{{ $enrollment->student->last_name }}
</p>

<p>
<strong>Grado:</strong>
{{ $enrollment->grade->name }}
</p>

<p>
<strong>Grupo:</strong>
{{ $enrollment->group->name ?? 'Sin grupo' }}
</p>

<p>
<strong>Estado:</strong>
{{ $enrollment->status }}
</p>

<a href="{{ route('admin.enrollments.index') }}"
class="btn btn-secondary">
Volver </a>

</div>
</div>

</div>

@endsection
