@extends('layouts.app')
@section('title', 'Editar Perfil de Profesor')

@push('styles')
    @vite('resources/css/teachers/edit.css')
@endpush

@section('content')

<div class="profile-form-container">

    <h2>✏️ Editar Profesor</h2>

    <form method="POST"
          action="{{ route('admin.teacher-profiles.update', $teacher->id) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="text" name="first_name"
               value="{{ old('first_name', $teacher->first_name) }}"
               placeholder="Nombres" required>

        <input type="text" name="last_name"
               value="{{ old('last_name', $teacher->last_name) }}"
               placeholder="Apellidos" required>

        <input type="text" name="dni"
               value="{{ old('dni', $teacher->dni) }}"
               placeholder="DNI" required>

        <input type="email" name="email"
               value="{{ old('email', $teacher->user->email) }}"
               placeholder="Correo electrónico" required>

        <input type="text" name="phone"
               value="{{ old('phone', $teacher->phone) }}"
               placeholder="Teléfono">

        <input type="text" name="address"
               value="{{ old('address', $teacher->address) }}"
               placeholder="Dirección">

        <input type="text" name="specialty"
               value="{{ old('specialty', $teacher->specialty) }}"
               placeholder="Especialidad">

        <input type="file" name="photo">
<div style="margin-top:20px;">
        <a href="{{ route('admin.teacher-profiles.index') }}" class="btn-back">⬅ Volver</a>
    </div>
    
        <button type="submit">💾 Actualizar</button>
    </form>


</div>

@endsection