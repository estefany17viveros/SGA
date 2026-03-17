@extends('layouts.app')

@section('title', 'Crear Perfil de Profesor')

@push('styles')
    @vite('resources/css/teachers/create.css')
@endpush

@section('content')

<div class="profile-form-container">

    <div class="form-header">
        <h2>👨‍🏫 Crear Perfil de Profesor</h2>
        <p class="form-subtitle">Completa todos los datos del nuevo profesor</p>
    </div>

    {{-- ✅ ERRORES GENERALES --}}
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
          action="{{ route('admin.teacher-profiles.store') }}"
          class="teacher-form"
          enctype="multipart/form-data">
        @csrf

        <div class="form-section">
            <h4>📋 Datos Personales</h4>

            <div class="form-group full-width">
                <label for="photo">🖼 Foto del Profesor</label>
                <input type="file" id="photo" name="photo" class="form-input" accept="image/*">
                @error('photo')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label>Nombres</label>
                    <input type="text" name="first_name" class="form-input"
                           value="{{ old('first_name') }}" required>
                    @error('first_name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Apellidos</label>
                    <input type="text" name="last_name" class="form-input"
                           value="{{ old('last_name') }}" required>
                    @error('last_name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>DNI</label>
                    <input type="text" name="dni" class="form-input"
                           value="{{ old('dni') }}" maxlength="8" required>
                    @error('dni')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="text" name="phone" class="form-input"
                           value="{{ old('phone') }}">
                    @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label>Dirección</label>
                    <input type="text" name="address" class="form-input"
                           value="{{ old('address') }}">
                    @error('address')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label>Especialidad</label>
                    <input type="text" name="specialty" class="form-input"
                           value="{{ old('specialty') }}">
                    @error('specialty')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-section">
            <h4>🔐 Datos de Acceso</h4>

            <div class="form-group full-width">
                <label>Correo Electrónico</label>
                <input type="email" name="email" class="form-input"
                       value="{{ old('email') }}" required>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group full-width">
                <label>Contraseña</label>
                <input type="password" name="password"
                       class="form-input" required minlength="6">
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.teacher-profiles.index') }}" class="btn-cancel">❌ Cancelar</a>
            <button type="submit" class="btn-submit">💾 Crear Profesor</button>
        </div>

    </form>

</div>
@endsection