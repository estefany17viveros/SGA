@extends('layouts.app')

@section('title', 'Editar Estudiante')

@push('styles')
@vite('resources/css/admin/students/edit.css')    
@endpush

@section('content')

<div class="edit-student-container">

    <!-- Header -->
    <div class="form-header">
        <h3>✏️ Editar Estudiante</h3>
        <p class="form-subtitle">Actualiza la información del estudiante</p>
    </div>

    <!-- ERRORES -->
    @if ($errors->any())
        <div class="alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulario -->
    <div class="form-card">
        <form action="{{ route('admin.students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-grid">

                <!-- Nombre -->
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="first_name"
                        value="{{ old('first_name', $student->first_name) }}"
                        class="form-input" required>
                </div>

                <!-- Apellido -->
                <div class="form-group">
                    <label>Apellido</label>
                    <input type="text" name="last_name"
                        value="{{ old('last_name', $student->last_name) }}"
                        class="form-input" required>
                </div>

                <!-- Género -->
                <div class="form-group">
                    <label>Género</label>
                    <select name="gender" class="form-input">
                        <option value="masculino" {{ old('gender', $student->gender) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="femenino" {{ old('gender', $student->gender) == 'femenino' ? 'selected' : '' }}>Femenino</option>
                    </select>
                </div>

                <!-- ✅ FECHA CORREGIDA -->
                <div class="form-group">
                    <label>Fecha de Nacimiento</label>
                    <input 
                        type="date"
                        name="birth_date"
                        value="{{ old('birth_date', optional($student->birth_date)->format('Y-m-d')) }}"
                        class="form-input"
                        required
                    >
                </div>

                <!-- Documento -->
                <div class="form-group">
                    <label>Documento</label>
                    <input type="text" name="identification_number"
                        value="{{ old('identification_number', $student->identification_number) }}"
                        class="form-input" required>
                </div>

                <!-- EPS -->
                <div class="form-group">
                    <label>EPS</label>
                    <input type="text" name="eps"
                        value="{{ old('eps', $student->eps) }}"
                        class="form-input" required>
                </div>

                <!-- Tipo de población -->
                <div class="form-group">
                    <label>Tipo de población</label>
                    <select name="population_type" class="form-input">
                        <option value="ninguno" {{ old('population_type', $student->population_type) == 'ninguno' ? 'selected' : '' }}>Ninguno</option>
                        <option value="afro" {{ old('population_type', $student->population_type) == 'afro' ? 'selected' : '' }}>Afro</option>
                        <option value="indigena" {{ old('population_type', $student->population_type) == 'indigena' ? 'selected' : '' }}>Indígena</option>
                        <option value="desplazado" {{ old('population_type', $student->population_type) == 'desplazado' ? 'selected' : '' }}>Desplazado</option>
                    </select>
                </div>

                <!-- Certificado -->
                <div class="form-group full-width">
                    <label>Certificado población</label>

                    @if($student->population_certificate)
                        <a href="{{ asset('storage/'.$student->population_certificate) }}" target="_blank">
                            📄 Ver actual
                        </a>
                    @endif

                    <input type="file" name="population_certificate" class="form-input">
                </div>

                <!-- Foto -->
                <div class="form-group full-width">
                    <label>Foto</label>

                    @if($student->photo)
                        <img src="{{ asset('storage/'.$student->photo) }}" width="80">
                    @endif

                    <input type="file" name="photo" class="form-input">
                </div>

            </div>

            <!-- Botones -->
            <div class="form-actions">
                <a href="{{ route('admin.students.index') }}" class="btn-cancel">
                    Cancelar
                </a>

                <button type="submit" class="btn-submit">
                    💾 Actualizar
                </button>
            </div>

        </form>
    </div>

</div>

@endsection