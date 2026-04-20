@extends('layouts.app')
@section('title', 'Información del estudiante')
@push('styles')
    @vite('resources/css/teacher/students/show.css')    
@endpush
@section('content')
<div class="container">

    <h2>👨‍🎓 Información del estudiante</h2>

    {{-- 🔹 FOTO --}}
    <div class="card mb-3 p-3 text-center">
        <h5>📷 Foto</h5>

        @if($student->photo)
            <img src="{{ asset('storage/' . $student->photo) }}"
                 width="140"
                 class="rounded">
        @else
            <p>Sin foto</p>
        @endif
    </div>

    {{-- 🔹 DATOS PERSONALES --}}
    <div class="card mb-3 p-3">
        <h5>📄 Datos personales</h5>

        <p><strong>Nombre:</strong> {{ $student->first_name }} {{ $student->last_name }}</p>
        <p><strong>Documento:</strong> {{ $student->identification_type }} - {{ $student->identification_number }}</p>
        <p><strong>Género:</strong> {{ $student->gender }}</p>
        <p><strong>Fecha nacimiento:</strong> {{ $student->birth_date }}</p>
        <p><strong>Edad:</strong> {{ $student->age }}</p>
    </div>

    {{-- 🔹 UBICACIÓN --}}
    <div class="card mb-3 p-3">
        <h5>📍 Ubicación</h5>

        <p><strong>Dirección:</strong> {{ $student->address }}</p>
        <p><strong>Expedición:</strong> {{ $student->expedition_department }} - {{ $student->expedition_municipality }}</p>
        <p><strong>Fecha expedición:</strong> {{ $student->expedition_date }}</p>
    </div>

    {{-- 🔹 SALUD --}}
    <div class="card mb-3 p-3">
        <h5>🏥 Salud</h5>

        <p><strong>EPS:</strong> {{ $student->eps }}</p>
        <p><strong>Tipo de sangre:</strong> {{ $student->blood_type }}</p>
        <p><strong>Condiciones médicas:</strong> {{ $student->medical_conditions ?? 'Ninguna' }}</p>
    </div>

    {{-- 🔹 POBLACIÓN --}}
    <div class="card mb-3 p-3">
        <h5>🌎 Población</h5>

        <p><strong>Tipo:</strong> {{ $student->population_type }}</p>

        @if($student->population_certificate)
            <a href="{{ asset('storage/' . $student->population_certificate) }}"
               target="_blank"
               class="btn btn-primary btn-sm">
                📄 Ver certificado
            </a>
        @endif
    </div>

    {{-- 🔹 ACUDIENTES --}}
    <div class="card mb-3 p-3">
        <h5>👨‍👩‍👧 Acudientes</h5>

        @if($student->guardians && $student->guardians->count())
            <ul>
                @foreach($student->guardians as $g)
                    <li>
                        <strong>{{ $g->first_name }} {{ $g->last_name }}</strong><br>
                        📞 {{ $g->phone ?? 'Sin teléfono' }}<br>
                        🏠 {{ $g->address ?? 'Sin dirección registrada' }}
                    </li>
                @endforeach
            </ul>
        @else
            <p>No tiene acudientes</p>
        @endif
    </div>

    {{-- 🔹 MATRÍCULA --}}
    <div class="card mb-3 p-3">
        <h5>🎓 Matrículas</h5>

        @if($student->enrollments && $student->enrollments->count())
            <ul>
                @foreach($student->enrollments as $e)
                    <li>
                       Año: {{ $e->academicYear->year ?? $e->academicYear->name ?? 'Sin año' }}
                        Grado: {{ $e->grade->name ?? 'Sin grado' }} |
                        Estado: {{ $e->status }}
</li>
                @endforeach
            </ul>
        @else
            <p>No tiene matrículas</p>
        @endif
    </div>

    {{-- 🔥 OBSERVADOR --}}
    <div class="card mb-3 p-3">
        <h5>📘 Observador</h5>

        <p>{{ $student->observations ?? 'Sin observaciones' }}</p>

        @if($student->certificate_file)
            <a href="{{ asset('storage/' . $student->certificate_file) }}"
               target="_blank"
               class="btn btn-primary btn-sm">
                📄 Ver PDF
            </a>
        @endif

        @if($isDirector ?? false)

            <hr>

            <form action="{{ route('teacher.students.observer.update', $student->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="mb-2">
                    <label>Editar observación</label>
                    <textarea name="observations"
                              class="form-control"
                              rows="3">{{ $student->observations }}</textarea>
                </div>

                <div class="mb-2">
                    <input type="file" name="certificate_file" class="form-control">
                </div>

                <button class="btn btn-success btn-sm">
                    💾 Guardar cambios
                </button>

            </form>

        @else
            <p class="text-muted mt-2">
                🔒 Solo el director del grupo puede editar el observador
            </p>
        @endif

    </div>

    <a href="{{ url()->previous() }}" class="btn btn-secondary">
        ⬅ Volver
    </a>

</div>
@endsection