@extends('layouts.app')

@section('title', 'Detalle del Estudiante')

@push('styles')
@vite('resources/css/admin/students/show.css')
@endpush

@section('content')

<div class="student-detail-container">

<div class="detail-header">
    <div class="header-left">
        <h3>📋 Detalle del Estudiante</h3>
    </div>

    <a href="{{ route('admin.students.index') }}" class="btn-back">
        ← Volver
    </a>
</div>


<div class="detail-card">
    <div class="card-content">

        <div class="student-layout">

            <!-- FOTO -->
            <div class="photo-section">

                @if($student->photo)
                    <div class="photo-frame">
                        <img src="{{ asset('storage/'.$student->photo) }}"
                             alt="Foto de {{ $student->full_name }}"
                             class="student-photo">
                    </div>
                @else
                    <div class="photo-placeholder-large">
                        👤
                        <p>Sin foto</p>
                    </div>
                @endif

            </div>



            <!-- INFORMACIÓN -->
            <div class="info-section">

                <div class="student-header">
                    <h4 class="student-name">{{ $student->full_name }}</h4>
                    <span class="age-badge">{{ $student->age }} años</span>
                </div>

                <div class="divider"></div>


                <!-- INFORMACIÓN BÁSICA -->
                <div class="info-block">

                    <h5 class="block-title">Información Básica</h5>

                    <div class="info-grid">

                        <div class="info-item">
                            <span class="info-label">Nombre:</span>
                            <span class="info-value">{{ $student->first_name }}</span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Apellido:</span>
                            <span class="info-value">{{ $student->last_name }}</span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Género:</span>
                            <span class="info-value">{{ ucfirst($student->gender) }}</span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Fecha Nacimiento:</span>
                            <span class="info-value">
                                {{ $student->birth_date ? $student->birth_date->format('d/m/Y') : '-' }}
                            </span>
                        </div>

                    </div>

                </div>


                <div class="divider"></div>


                <!-- DOCUMENTO -->
                <div class="info-block">

                    <h5 class="block-title">Documento de Identidad</h5>

                    <div class="info-grid">

                        <div class="info-item">
                            <span class="info-label">Tipo Documento:</span>
                            <span class="info-value">
                                {{ ucfirst(str_replace('_',' ',$student->identification_type)) }}
                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Número Documento:</span>
                            <span class="info-value">
                                {{ $student->identification_number }}
                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Fecha Expedición:</span>
                            <span class="info-value">
                                {{ $student->expedition_date ? $student->expedition_date->format('d/m/Y') : '-' }}
                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Departamento:</span>
                            <span class="info-value">
                                {{ $student->expedition_department }}
                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Municipio:</span>
                            <span class="info-value">
                                {{ $student->expedition_municipality }}
                            </span>
                        </div>

                    </div>

                </div>


                <div class="divider"></div>


                <!-- DIRECCIÓN -->
                <div class="info-block">

                    <h5 class="block-title">Residencia</h5>

                    <div class="info-grid">

                        <div class="info-item full-width">
                            <span class="info-label">Dirección:</span>
                            <span class="info-value">
                                {{ $student->address }}
                            </span>
                        </div>

                    </div>

                </div>


                <div class="divider"></div>


                <!-- SALUD -->
                <div class="info-block">

                    <h5 class="block-title">Información de Salud</h5>

                    <div class="info-grid">

                        <div class="info-item">
                            <span class="info-label">EPS:</span>
                            <span class="info-value">{{ $student->eps }}</span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Tipo Sangre:</span>
                            <span class="info-value">{{ $student->blood_type }}</span>
                        </div>

                        <div class="info-item full-width">
                            <span class="info-label">Condiciones Médicas:</span>
                            <span class="info-value">
                                {{ $student->medical_conditions ?? 'Sin condiciones médicas registradas' }}
                            </span>
                        </div>

                    </div>

                </div>


                <div class="divider"></div>

<div class="divider"></div>

<!-- POBLACIÓN -->
<div class="info-block">

    <h5 class="block-title">Población Especial</h5>

    <div class="info-grid">

        <div class="info-item">
            <span class="info-label">Tipo:</span>
            <span class="info-value">
                @if($student->population_type && $student->population_type != 'ninguno')
                    {{ ucfirst($student->population_type) }}
                @else
                    No aplica
                @endif
            </span>
        </div>

        <div class="info-item full-width">
            <span class="info-label">Certificado:</span>

            @if($student->population_certificate)

                <a href="{{ asset('storage/'.$student->population_certificate) }}"
                   target="_blank"
                   class="btn-certificate">
                    📄 Ver Certificado
                </a>

                <a href="{{ asset('storage/'.$student->population_certificate) }}"
                   download
                   class="btn-certificate">
                    ⬇ Descargar
                </a>

            @else
                <span class="info-value">No tiene certificado</span>
            @endif

        </div>

    </div>

</div>


                <div class="divider"></div>

            <!-- HISTORIAL ACADÉMICO -->
            <div class="info-block">

            <h5 class="block-title">📚 Historial Académico</h5>

            @if($student->enrollments->count() > 0)

            <table class="table table-bordered">

            <thead>
            <tr>
            <th>Año</th>
            <th>Grado</th>
            <th>Grupo</th>
            <th>Estado</th>
            </tr>
            </thead>

            <tbody>

            @foreach($student->enrollments as $enrollment)

            <tr>

            <td>
            {{ $enrollment->academicYear->year ?? '-' }}
            </td>

            <td>
            {{ $enrollment->grade->name ?? '-' }}
            </td>

            <td>
            {{ $enrollment->group->name ?? 'Sin grupo' }}
            </td>

            <td>
@if(
    ($enrollment->status == 'aprobado' && $enrollment->grade->level == 11)
    || $enrollment->status == 'graduado'
)
    <span class="badge bg-primary">🎓 Graduado</span>

@elseif($enrollment->status == 'aprobado')
    <span class="badge bg-success">Aprobado</span>

@elseif($enrollment->status == 'reprobado')
    <span class="badge bg-danger">Reprobado</span>

@elseif($enrollment->status == 'matriculado')
    <span class="badge bg-warning">Matriculado</span>

@elseif($enrollment->status == 'retirado')
    <span class="badge bg-secondary">Retirado</span>
@endif
            </td>

            </tr>

            @endforeach

            </tbody>

            </table>

            @else

            <p>No existe historial académico.</p>

            @endif

            </div>
                <!-- OBSERVACIONES -->
                <div class="info-block">

                    <h5 class="block-title">Observaciones</h5>

                    <div class="observations-box">
                        {{ $student->observations ?? 'No existen observaciones registradas.' }}
                    </div>

                </div>

                <!-- CERTIFICADO -->
                <div class="info-block">

                    <h5 class="block-title">Certificado PDF</h5>

                    @if($student->certificate_file)

                        <a href="{{ asset('storage/'.$student->certificate_file) }}"
                           target="_blank"
                           class="btn-certificate">
                            📄 Ver Certificado
                        </a>

                        <a href="{{ asset('storage/'.$student->certificate_file) }}"
                           download
                           class="btn-certificate">
                            ⬇ Descargar Certificado
                        </a>

                    @else
                        <p>No se ha subido certificado.</p>
                    @endif

                </div>

                <div class="divider"></div>


                <!-- ACUDIENTES -->
                <div class="info-block">

                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                        <h5 class="block-title">Acudientes</h5>

                        <a href="{{ route('admin.guardians.create', $student->id) }}"
                           class="btn btn-success btn-sm">
                           ➕ Agregar Acudiente
                        </a>
                    </div>


                    @if($student->guardians->count() > 0)

                    <table class="table table-bordered">

                        <thead>
                            <tr>
                                <th>Nombre</th>
                                    <th>Apellido</th>
                                <th>Parentesco</th>
                                <th>Teléfono</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($student->guardians as $guardian)

                            <tr>

                                <td>{{ $guardian->first_name }}</td>

                                <td>{{ $guardian->last_name }}</td>

                                <td>{{ $guardian->relationship }}</td>

                                <td>{{ $guardian->phone }}</td>

                                <td>

                                    <a href="{{ route('admin.guardians.show',$guardian->id) }}"
                                       class="btn btn-primary btn-sm">
                                       👁️ Ver datos
                                    </a>

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                    @else

                        <p>No hay acudientes registrados.</p>

                    @endif

                </div>

            </div>

        </div>

    </div>
</div>


</div>

@endsection
