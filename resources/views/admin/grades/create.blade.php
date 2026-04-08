@extends('layouts.app')
@section('title', 'Crear Grado')
@push('styles')
@vite('resources/css/admin/grades/create.css')
@endpush
@section('content')
<div class="container">

    <h2>Crear Grado</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.grades.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Grado</label>

            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name') }}"
                   placeholder="Ej: Sexto"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nivel</label>

            <input type="number"
                   name="level"
                   class="form-control"
                   value="{{ old('level') }}"
                   placeholder="Ej: 6"
                   required>
        </div>

        <button class="btn btn-success">
            Guardar
        </button>

        <a href="{{ route('admin.grades.index') }}"
           class="btn btn-secondary">
           Cancelar
        </a>

    </form>

</div>
@endsection