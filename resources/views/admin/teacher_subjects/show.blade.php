@extends('layouts.app')

@push('styles')
@vite('resources/css/admin/teachersubjects/show.css')
@endpush

@section('content')

<div class="container">

    <h2 class="mb-4">📘 Detalle de Asignación</h2>

    <div class="detail-card">

        {{-- Profesor --}}
        <div class="detail-row">
            <span class="detail-label">Profesor</span>
            <span class="detail-value">
                {{ $assignment->teacher->first_name }} {{ $assignment->teacher->last_name }}
            </span>
        </div>

        {{-- Materia --}}
        <div class="detail-row">
            <span class="detail-label">Materia</span>
            <span class="detail-value">
                {{ $assignment->subject->name }}
            </span>
        </div>

        {{-- Grado --}}
        <div class="detail-row">
            <span class="detail-label">Grado</span>
            <span class="detail-value">
                {{ $assignment->grade->name }}
            </span>
        </div>

        {{-- Grupo --}}
        <div class="detail-row">
            <span class="detail-label">Grupo</span>
            <span class="detail-value">
                {{ $assignment->group ? $assignment->group->name : 'General' }}
            </span>
        </div>

        {{-- Año --}}
        <div class="detail-row">
            <span class="detail-label">Año</span>
            <span class="detail-value">
                {{ $assignment->academicYear->year }}
            </span>
        </div>

        {{-- Estado --}}
        <div class="detail-row">
            <span class="detail-label">Estado</span>
            <span class="detail-value">
                <span class="badge {{ $assignment->status ? 'badge-activo' : 'badge-inactivo' }}">
                    {{ $assignment->status ? 'Activo' : 'Inactivo' }}
                </span>
            </span>
        </div>

    </div>

    {{-- BOTÓN --}}
    <div class="mt-4">
        <a href="{{ route('admin.teacher-subjects.index') }}" class="btn btn-secondary">
            ← Volver
        </a>
    </div>

</div>

@endsection