@extends('layouts.app')

@section('title', 'Detalles del Profesor')

@push('styles')
    @vite('resources/css/teachers/show.css')
@endpush

@section('content')

<div class="profile-card">

    <h2>👨‍🏫 Detalles del Profesor</h2>

    {{-- Mostrar la foto --}}
    @if($teacher->photo)
        <img 
            src="{{ asset('storage/' . $teacher->photo) }}" 
            alt="Foto de {{ $teacher->first_name }}"
            class="teacher-photo"
        >
    @else
        <img 
            src="{{ asset('storage/teachers/default_teacher.png') }}" 
            alt="Foto por defecto"
            class="teacher-photo"
        >
    @endif

    <div class="profile-info">
        <p><strong>Nombres:</strong> {{ $teacher->first_name }}</p>
        <p><strong>Apellidos:</strong> {{ $teacher->last_name }}</p>
        <p><strong>DNI:</strong> {{ $teacher->dni }}</p>
        <p><strong>Teléfono:</strong> {{ $teacher->phone }}</p>
        <p><strong>Dirección:</strong> {{ $teacher->address }}</p>
        <p><strong>Especialidad:</strong> {{ $teacher->specialty }}</p>
        <p><strong>Correo:</strong> {{ $teacher->user->email }}</p>
    </div>

    <div style="margin-top:20px;">
        <a href="{{ route('admin.teacher-profiles.index') }}" class="btn-back">⬅ Volver</a>
    </div>

</div>

@endsection