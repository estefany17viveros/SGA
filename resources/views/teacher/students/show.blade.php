@extends('layouts.app')
@section('title', 'Información del estudiante')
@push('styles')
    @vite('resources/css/teacher/students/show.css')
@endpush
@section('content')
<div class="container">

    <h2>👨‍🎓 Información del estudiante</h2>

    <div class="student-layout">

        {{-- ===================== COLUMNA IZQUIERDA ===================== --}}
        <div class="student-col-left">

            {{-- FOTO --}}
            <div class="card card-foto">
                <h5>📷 Foto</h5>
                @if($student->photo)
                    <img src="{{ asset('storage/' . $student->photo) }}"
                         width="110" class="rounded">
                @else
                    <div class="sin-foto">Sin foto</div>
                @endif
            </div>

            {{-- DATOS PERSONALES --}}
            <div class="card">
                <h5>📄 Datos personales</h5>
                <p><strong>Nombre:</strong> {{ $student->first_name }} {{ $student->last_name }}</p>
                <p><strong>Documento:</strong> {{ $student->identification_type }} – {{ $student->identification_number }}</p>
                <p><strong>Género:</strong> {{ $student->gender }}</p>
                <p><strong>Nacimiento:</strong> {{ $student->birth_date }}</p>
                <p><strong>Edad:</strong> {{ $student->age }}</p>
            </div>

            {{-- UBICACIÓN --}}
            <div class="card">
                <h5>📍 Ubicación</h5>
                <p><strong>Dirección:</strong> {{ $student->address }}</p>
                <p><strong>Expedición:</strong> {{ $student->expedition_department }} – {{ $student->expedition_municipality }}</p>
                <p><strong>Fecha expedición:</strong> {{ $student->expedition_date }}</p>
            </div>

            {{-- SALUD --}}
            <div class="card">
                <h5>🏥 Salud</h5>
                <p><strong>EPS:</strong> {{ $student->eps }}</p>
                <p><strong>Tipo de sangre:</strong> {{ $student->blood_type }}</p>
                <p><strong>Condiciones:</strong> {{ $student->medical_conditions ?? 'Ninguna' }}</p>
            </div>

            {{-- POBLACIÓN --}}
            <div class="card">
                <h5>🌎 Población</h5>
                <p><strong>Tipo:</strong> {{ $student->population_type }}</p>
                @if($student->population_certificate)
                    <a href="{{ asset('storage/' . $student->population_certificate) }}"
                       target="_blank"
                       class="btn-pdf">
                        📄 Ver certificado
                    </a>
                @endif
            </div>

            {{-- ACUDIENTES --}}
            <div class="card">
                <h5>👨‍👩‍👧 Acudientes</h5>
                @if($student->guardians && $student->guardians->count())
                    <ul>
                        @foreach($student->guardians as $g)
                            <li>
                                <strong>{{ $g->first_name }} {{ $g->last_name }}</strong>
                                📞 {{ $g->phone ?? 'Sin teléfono' }}<br>
                                🏠 {{ $g->address ?? 'Sin dirección registrada' }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No tiene acudientes registrados</p>
                @endif
            </div>

            {{-- MATRÍCULAS --}}
            <div class="card card-matricula">
                <h5>🎓 Matrículas</h5>
                @if($student->enrollments && $student->enrollments->count())
                    <ul>
                        @foreach($student->enrollments as $e)
                            <li>
                                <strong>{{ $e->academicYear->year ?? $e->academicYear->name ?? 'Sin año' }}</strong>
                                Grado: {{ $e->grade->name ?? 'Sin grado' }} &nbsp;|&nbsp; Estado: {{ $e->status }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No tiene matrículas registradas</p>
                @endif
            </div>

        </div>

        {{-- ===================== COLUMNA DERECHA ===================== --}}
        <div class="student-col-right">

            {{-- OBSERVADOR --}}
            <div class="card">
                <h5>📘 Observador</h5>

                <div class="obs-texto">
                    {{ $student->observations ?? 'Sin observaciones registradas' }}
                </div>

                @if($student->certificate_file)
                    <a href="{{ asset('storage/' . $student->certificate_file) }}"
                       target="_blank"
                       class="btn-pdf">
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
                                      rows="4">{{ $student->observations }}</textarea>
                        </div>

                        <div class="mb-2">
                            <label>Subir archivo PDF</label>
                            <input type="file" name="certificate_file" class="form-control">
                        </div>

                        <button type="submit" class="btn-guardar">
                            💾 Guardar cambios
                        </button>

                    </form>

                @else
                    <p class="aviso-director">
                        🔒 Solo el director del grupo puede editar el observador
                    </p>
                @endif

            </div>

        </div>

    </div>{{-- /student-layout --}}

    <a href="{{ url()->previous() }}" class="btn-volver">
        ⬅ Volver
    </a>

</div>
@endsection