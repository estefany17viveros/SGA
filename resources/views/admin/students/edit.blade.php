@extends('layouts.app')

@section('title', 'Editar Estudiante')

@push('styles')
@vite('resources/css/students/edit.css')    
@endpush

@section('content')

<div class="edit-student-container">

    <!-- Header -->
    <div class="form-header">
        <h3>✏️ Editar Estudiante</h3>
        <p class="form-subtitle">Actualiza la información del estudiante</p>
    </div>

    <!-- Formulario -->
    <div class="form-card">
        <form action="{{ route('admin.students.update', $student) }}" method="POST" enctype="multipart/form-data" class="edit-form">
            @csrf
            @method('PUT')

            <div class="form-grid">

                <!-- Nombre -->
                <div class="form-group">
                    <label for="first_name">
                        <span class="label-icon">✏️</span>
                        Nombre
                    </label>
                    <input 
                        type="text" 
                        id="first_name"
                        name="first_name" 
                        value="{{ old('first_name', $student->first_name) }}" 
                        class="form-input"
                        required
                    >
                </div>

                <!-- Apellido -->
                <div class="form-group">
                    <label for="last_name">
                        <span class="label-icon">✏️</span>
                        Apellido
                    </label>
                    <input 
                        type="text" 
                        id="last_name"
                        name="last_name" 
                        value="{{ old('last_name', $student->last_name) }}" 
                        class="form-input"
                        required
                    >
                </div>

                <!-- Género -->
                <div class="form-group">
                    <label for="gender">
                        <span class="label-icon">⚧️</span>
                        Género
                    </label>
                    <select name="gender" id="gender" class="form-input">
                        <option value="masculino" {{ old('gender', $student->gender) == 'masculino' ? 'selected' : '' }}>
                            Masculino
                        </option>
                        <option value="femenino" {{ old('gender', $student->gender) == 'femenino' ? 'selected' : '' }}>
                            Femenino
                        </option>
                    </select>
                </div>

                <!-- Fecha de nacimiento -->
                <div class="form-group">
                    <label for="birth_date">
                        <span class="label-icon">📅</span>
                        Fecha de Nacimiento
                    </label>
                    <input 
                        type="date" 
                        id="birth_date"
                        name="birth_date"
                        value="{{ old('birth_date', $student->birth_date->format('Y-m-d')) }}"
                        class="form-input"
                        required
                    >
                </div>

                <!-- Documento -->
                <div class="form-group">
                    <label for="identification_number">
                        <span class="label-icon">🆔</span>
                        Número de Documento
                    </label>
                    <input 
                        type="text" 
                        id="identification_number"
                        name="identification_number"
                        value="{{ old('identification_number', $student->identification_number) }}"
                        class="form-input"
                        required
                    >
                </div>

                <!-- EPS -->
                <div class="form-group">
                    <label for="eps">
                        <span class="label-icon">🏥</span>
                        EPS
                    </label>
                    <input 
                        type="text" 
                        id="eps"
                        name="eps"
                        value="{{ old('eps', $student->eps) }}"
                        class="form-input"
                        required
                    >
                </div>

                <!-- Foto -->
                <div class="form-group full-width">
                    <label for="photo">
                        <span class="label-icon">📷</span>
                        Foto
                    </label>
                    
                    @if($student->photo)
                        <div class="current-photo">
                            <img src="{{ asset('storage/'.$student->photo) }}" alt="Foto actual" class="photo-preview">
                            <span class="photo-label">Foto actual</span>
                        </div>
                    @endif
                    
                    <input 
                        type="file" 
                        id="photo"
                        name="photo" 
                        class="form-input file-input"
                        accept="image/*"
                    >
                    <small class="form-hint">Selecciona una nueva foto si deseas cambiarla</small>
                </div>

            </div>

            <!-- Botones de acción -->
            <div class="form-actions">
                <a href="{{ route('admin.students.index') }}" class="btn-cancel">
                    <span class="icon">❌</span>
                    Cancelar
                </a>
                <button type="submit" class="btn-submit">
                    <span class="icon">💾</span>
                    Actualizar Estudiante
                </button>
            </div>

        </form>
    </div>

</div>

@endsection