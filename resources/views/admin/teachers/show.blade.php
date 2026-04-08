@extends('layouts.app')
@section('title', 'Profesores')
@push('styles')
    @vite('resources/css/admin/teachers/show.css')
@endpush
@section('content')

<h2>{{ $teacher->full_name }}</h2>

{{-- FOTO --}}
@if($teacher->photo)
    <img src="{{ asset('storage/'.$teacher->photo) }}" width="120">
@endif

<p><strong>Edad:</strong> {{ $teacher->age }} años</p>

<p><strong>Documento:</strong> {{ $teacher->document_type }} - {{ $teacher->document_number }}</p>

<p><strong>Género:</strong> {{ $teacher->gender }}</p>

<p><strong>Fecha de nacimiento:</strong> {{ $teacher->birth_date }}</p>

<p><strong>Departamento expedición:</strong> {{ $teacher->expedition_department }}</p>

<p><strong>Municipio expedición:</strong> {{ $teacher->expedition_municipality }}</p>

<p><strong>Teléfono:</strong> {{ $teacher->phone ?? 'N/A' }}</p>

<p><strong>Dirección:</strong> {{ $teacher->address ?? 'N/A' }}</p>

<p><strong>Especialidad:</strong> {{ $teacher->specialty ?? 'N/A' }}</p>

<p><strong>Correo:</strong> {{ $teacher->user->email }}</p>

<p><strong>Fecha de ingreso:</strong> {{ $teacher->start_date }}</p>

<p><strong>Fecha de fin:</strong> {{ $teacher->end_date ?? 'Sin definir' }}</p>

<p>
    <strong>Estado:</strong>
    @if($teacher->is_active)
        <span style="color: green">Activo</span>
    @else
        <span style="color: red">Inactivo</span>
    @endif
</p>

{{-- PDF --}}
@if($teacher->cv)
    <p>
        <a href="{{ asset('storage/'.$teacher->cv) }}" target="_blank">
            📄 Ver hoja de vida
        </a>
    </p>
@endif

<br>

<a href="{{ route('admin.teachers.index') }}">⬅ Volver</a>

@endsection