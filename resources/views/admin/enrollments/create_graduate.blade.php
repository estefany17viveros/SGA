
@extends('layouts.app')

@section('title','Crear Egresado')
@push('styles')
    @vite(['resources/css/admin/enrollments/graduatescreate.css'])  
@endpush
@section('content')

<div class="container">

    <h3>➕ Crear Egresado</h3>

    {{-- MENSAJES --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.enrollments.store_graduate') }}" method="POST">
        @csrf

        <div class="row">

            {{-- NOMBRE --}}
            <div class="col-md-6">
                <label>Nombre</label>
                <input type="text"
                       name="first_name"
                       class="form-control"
                       value="{{ old('first_name') }}"
                       required>
            </div>

            {{-- APELLIDO --}}
            <div class="col-md-6">
                <label>Apellido</label>
                <input type="text"
                       name="last_name"
                       class="form-control"
                       value="{{ old('last_name') }}"
                       required>
            </div>

            {{-- DOCUMENTO --}}
            <div class="col-md-6 mt-2">
                <label>Documento</label>
                <input type="text"
                       name="identification_number"
                       class="form-control"
                       value="{{ old('identification_number') }}">
            </div>

            {{-- TELÉFONO --}}
            <div class="col-md-6 mt-2">
                <label>Teléfono</label>
                <input type="text"
                       name="phone"
                       class="form-control"
                       value="{{ old('phone') }}">
            </div>

            {{-- DIRECCIÓN --}}
            <div class="col-md-6 mt-2">
                <label>Dirección</label>
                <input type="text"
                       name="address"
                       class="form-control"
                       value="{{ old('address') }}">
            </div>

            {{-- FECHA NACIMIENTO --}}
            <div class="col-md-6 mt-2">
                <label>Fecha de nacimiento</label>
                <input type="date"
                       name="birth_date"
                       class="form-control"
                       value="{{ old('birth_date') }}">
            </div>

            {{-- AÑO EGRESO (TEXTO LIBRE) --}}
            <div class="col-md-6 mt-2">
                <label>Año de graduación</label>
                <input type="text"
                       name="year"
                       class="form-control"
                       placeholder="Ej: 2024 o Promoción 2024"
                       value="{{ old('year') }}"
                       required>
            </div>

        </div>

        {{-- BOTONES --}}
        <div class="mt-3 d-flex gap-2">
            <button class="btn btn-primary">
                💾 Guardar
            </button>

            <a href="{{ route('admin.enrollments.graduated') }}" class="btn btn-secondary">
                Cancelar
            </a>
        </div>

    </form>

</div>

@endsection