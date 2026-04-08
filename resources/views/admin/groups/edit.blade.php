@extends('layouts.app')
@section('title', 'Editar Grupo')
@push('styles')
@vite('resources/css/admin/groups/edit.css')

@endpush
@section('content')
<div class="container">

    <h4 class="mb-3">
        Editar Grupo - {{ $group->grade->name }}
    </h4>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('admin.grades.groups.update', [$group->grade_id, $group->id]) }}" 
                  method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nombre del Grupo</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $group->name) }}"
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
                           value="{{ old('capacity', $group->capacity) }}"
                           min="0"
                           required>
                    @error('capacity')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Estado</label>
                    <select name="status" class="form-select">
                        <option value="activo"
                            {{ $group->status === 'activo' ? 'selected' : '' }}>
                            Activo
                        </option>
                        <option value="cerrado"
                            {{ $group->status === 'cerrado' ? 'selected' : '' }}>
                            Cerrado
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">
                    Actualizar
                </button>

                <a href="{{ route('admin.grades.groups.index', $group->grade_id) }}"
                   class="btn btn-secondary">
                    Volver
                </a>

            </form>

        </div>
    </div>

</div>
@endsection