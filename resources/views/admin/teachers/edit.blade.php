@extends('layouts.app')

@push('styles')
    @vite('resources/css/teachers/edit.css')
@endpush

@section('content')

<h2>✏️ Editar Profesor</h2>

{{-- 🔴 ERRORES --}}
@if ($errors->any())
    <div style="color:red; margin-bottom:15px;">
        <strong>⚠️ Errores:</strong>
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

{{-- ✅ MENSAJE --}}
@if(session('success'))
    <div style="color:green; margin-bottom:15px;">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('admin.teachers.update', $teacher->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- ========================= --}}
    {{-- 👨‍🏫 PROFESOR (LIMITADO) --}}
    {{-- ========================= --}}
    @if(auth()->id() === $teacher->user_id)

        <label>Teléfono</label>
        <input type="text" name="phone" value="{{ old('phone', $teacher->phone) }}">

        <label>Dirección</label>
        <input type="text" name="address" value="{{ old('address', $teacher->address) }}">

        <label>Correo</label>
        <input type="email" name="email" value="{{ old('email', $teacher->user->email) }}">

    @else

    {{-- ========================= --}}
    {{-- 🔐 ADMIN COMPLETO --}}
    {{-- ========================= --}}

        <label>Nombres</label>
        <input type="text" name="first_name" value="{{ old('first_name', $teacher->first_name) }}">

        <label>Apellidos</label>
        <input type="text" name="last_name" value="{{ old('last_name', $teacher->last_name) }}">

        <label>Género</label>
        <select name="gender">
            <option value="masculino" {{ $teacher->gender=='masculino'?'selected':'' }}>Masculino</option>
            <option value="femenino" {{ $teacher->gender=='femenino'?'selected':'' }}>Femenino</option>
            <option value="otro" {{ $teacher->gender=='otro'?'selected':'' }}>Otro</option>
        </select>

        <label>Tipo Documento</label>
        <select name="document_type">
            <option value="cc" {{ $teacher->document_type=='cc'?'selected':'' }}>CC</option>
            <option value="ti" {{ $teacher->document_type=='ti'?'selected':'' }}>TI</option>
            <option value="ce" {{ $teacher->document_type=='ce'?'selected':'' }}>CE</option>
            <option value="pasaporte" {{ $teacher->document_type=='pasaporte'?'selected':'' }}>Pasaporte</option>
        </select>

        <label>Número Documento</label>
        <input type="text" name="document_number" value="{{ old('document_number', $teacher->document_number) }}">

        <label>Departamento de Expedición</label>
        <input type="text" name="expedition_department" value="{{ old('expedition_department', $teacher->expedition_department) }}">

        <label>Municipio de Expedición</label>
        <input type="text" name="expedition_municipality" value="{{ old('expedition_municipality', $teacher->expedition_municipality) }}">

        {{-- 🔥 CORRECCIÓN CLAVE (FECHAS) --}}
        <label>Fecha de Nacimiento</label>
        <input type="date" name="birth_date" value="{{ old('birth_date', optional($teacher->birth_date)->format('Y-m-d')) }}">

        <label>Fecha de Ingreso</label>
        <input type="date" name="start_date" value="{{ old('start_date', optional($teacher->start_date)->format('Y-m-d')) }}">

        <label>Fecha de Fin</label>
        <input type="date" name="end_date" value="{{ old('end_date', optional($teacher->end_date)->format('Y-m-d')) }}">

        <label>Teléfono</label>
        <input type="text" name="phone" value="{{ old('phone', $teacher->phone) }}">

        <label>Dirección</label>
        <input type="text" name="address" value="{{ old('address', $teacher->address) }}">

        <label>Especialidad</label>
        <input type="text" name="specialty" value="{{ old('specialty', $teacher->specialty) }}">

        {{-- FOTO --}}
        @if($teacher->photo)
            <p>Foto actual:</p>
            <img src="{{ asset('storage/'.$teacher->photo) }}" width="100">
        @endif

        <label>Nueva Foto</label>
        <input type="file" name="photo">

        {{-- PDF --}}
        @if($teacher->cv)
            <p>
                <a href="{{ asset('storage/'.$teacher->cv) }}" target="_blank">
                    📄 Ver hoja de vida actual
                </a>
            </p>
        @endif

        <label>Subir nueva hoja de vida</label>
        <input type="file" name="cv">

        <label>
            <input type="checkbox" name="is_active" {{ $teacher->is_active ? 'checked' : '' }}>
            Activo
        </label>

    @endif

    <br><br>
    <button type="submit">💾 Actualizar</button>

</form>

@endsection