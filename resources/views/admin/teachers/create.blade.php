@extends('layouts.app')

@section('title', 'Crear Perfil de Profesor')

@push('styles')
    @vite('resources/css/admin/teachers/create.css')
@endpush

@section('content')

<div class="profile-form-container">

    <div class="form-header">
        <h2>👨‍🏫 Crear Perfil de Profesor</h2>
        <p class="form-subtitle">Completa todos los datos del nuevo profesor</p>
    </div>

    @if ($errors->any())
        <div class="error-message">
            <strong>⚠️ Se encontraron errores:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="success-message">
            <span class="message-icon">✓</span>
            {{ session('success') }}
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.teachers.store') }}"
          class="teacher-form"
          enctype="multipart/form-data">
        @csrf

        <div class="form-section">
            <h4>📋 Datos Personales</h4>

            <div class="form-group full-width">
                <label for="photo">🖼 Foto del Profesor</label>
                <input type="file" id="photo" name="photo" class="form-input" accept="image/*">
            </div>

            <div class="form-grid">

                {{-- EXISTENTES --}}
                <div class="form-group">
                    <label>Nombres</label>
                    <input type="text" name="first_name" class="form-input" value="{{ old('first_name') }}" required>
                </div>

                <div class="form-group">
                    <label>Apellidos</label>
                    <input type="text" name="last_name" class="form-input" value="{{ old('last_name') }}" required>
                </div>

                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="text" name="phone" class="form-input" value="{{ old('phone') }}">
                </div>

                <div class="form-group full-width">
                    <label>Dirección</label>
                    <input type="text" name="address" class="form-input" value="{{ old('address') }}">
                </div>

                <div class="form-group full-width">
                    <label>Especialidad</label>
                    <input type="text" name="specialty" class="form-input" value="{{ old('specialty') }}">
                </div>

                {{-- 🆕 NUEVOS CAMPOS --}}
                
                <div class="form-group">
                    <label>Género</label>
                    <select name="gender" class="form-input" required>
                        <option value="">Seleccione</option>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tipo Documento</label>
                    <select name="document_type" class="form-input" required>
                        <option value="">Seleccione</option>
                        <option value="cc">CC</option>
                        <option value="ti">TI</option>
                        <option value="ce">CE</option>
                        <option value="pasaporte">Pasaporte</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Número Documento</label>
                    <input type="text" name="document_number" class="form-input" required>
                </div>

                <div class="form-group">
                    <label>Departamento Expedición</label>
                    <input type="text" name="expedition_department" class="form-input">
                </div>

                <div class="form-group">
                    <label>Municipio Expedición</label>
                    <input type="text" name="expedition_municipality" class="form-input">
                </div>

                <div class="form-group">
                    <label>Fecha de Nacimiento</label>
                    <input type="date" name="birth_date" class="form-input" required>
                </div>

                <div class="form-group">
                    <label>Fecha de Ingreso</label>
                    <input type="date" name="start_date" class="form-input" required>
                </div>

                <div class="form-group">
                    <label>Fecha de Fin</label>
                    <input type="date" name="end_date" class="form-input">
                </div>

                <div class="form-group full-width">
                    <label>Hoja de Vida (PDF)</label>
                    <input type="file" name="cv" class="form-input">
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_active" checked>
                        Usuario Activo
                    </label>
                </div>

            </div>
        </div>

        <div class="form-section">
            <h4>🔐 Datos de Acceso</h4>

            <div class="form-group full-width">
                <label>Correo Electrónico</label>
                <input type="email" name="email" class="form-input" value="{{ old('email') }}" required>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.teachers.index') }}" class="btn-cancel">❌ Cancelar</a>
            <button type="submit" class="btn-submit">💾 Crear Profesor</button>
        </div>

    </form>

</div>
@endsection