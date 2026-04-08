@extends('layouts.app')
@section('title', 'Crear Grupo')
@push('styles')
@vite('resources/css/admin/groups/create.css')
@endpush
@section('content')
<div class="container">

    <h4 class="mb-3">
        Crear Grupo - {{ $grade->name }}
    </h4>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('admin.grades.groups.store', $grade->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nombre del Grupo</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name') }}"
                           required>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Capacidad</label>
                    <input type="number"
                           name="capacity"
                           class="form-control"
                           value="{{ old('capacity') }}"
                           min="0"
                           required>
                    @error('capacity')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button class="btn btn-success">Guardar</button>
                <a href="{{ route('admin.grades.groups.index', $grade->id) }}"
                   class="btn btn-secondary">
                    Cancelar
                </a>

            </form>

        </div>
    </div>

</div>
@endsection