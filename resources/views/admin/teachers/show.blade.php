@extends('layouts.app')
@section('title', 'Profesores')

@push('styles')
    @vite('resources/css/admin/teachers/show.css')
@endpush

@section('content')
<div class="teacher-profile-container">
    <h2>{{ $teacher->full_name }}</h2>

    {{-- FOTO --}}
    @if($teacher->photo)
        <img src="{{ asset('storage/'.$teacher->photo) }}" class="profile-img">
    @endif

    <div class="info-card">
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
                <span class="status-badge active">Activo</span>
            @else
                <span class="status-badge inactive">Inactivo</span>
            @endif
        </p>
    </div>

    {{-- PDF --}}
    @if($teacher->cv)
        <div class="actions">
            <a href="{{ asset('storage/'.$teacher->cv) }}" target="_blank" class="btn-cv">
                📄 Ver hoja de vida
            </a>
        </div>
    @endif

    <a href="{{ route('admin.teachers.index') }}" class="btn-back">⬅ Volver</a>
</div>
@endsection