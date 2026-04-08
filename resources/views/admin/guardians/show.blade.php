
@extends('layouts.app')

@section('title','Detalle Acudiente')
@push('styles')
@vite('resources/css/admin/guardians/show.css')
@endpush
@section('content')

<div class="container">

<h3>Detalle del Acudiente</h3>

<div class="card">

<div class="card-body">

<p><strong>Nombre:</strong> {{ $guardian->first_name }}</p>

<p><strong>Apellido:</strong> {{ $guardian->last_name }}</p>

<p><strong>Parentesco:</strong> {{ $guardian->relationship }}</p>

<p><strong>Identificación:</strong> {{ $guardian->identification_number }}</p>

<p><strong>Teléfono:</strong> {{ $guardian->phone }}</p>

<p><strong>Email:</strong> {{ $guardian->email }}</p>

<p><strong>Ocupación:</strong> {{ $guardian->occupation }}</p>

<p><strong>Dirección:</strong> {{ $guardian->address }}</p>

<p><strong>Estudiante:</strong> {{ $guardian->student->full_name ?? '' }}</p>

<a href="{{ route('admin.guardians.index') }}"
class="btn btn-secondary">
Volver
</a>

</div>

</div>

</div>

@endsection
