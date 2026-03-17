@extends('layouts.app')
@section('title', 'Grupos del Grado')
@push('styles')
@vite('resources/css/groups/index.css')
@endpush
@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">
                Grupos del Grado: {{ $grade->name }}
            </h4>
           
        </div>

        <a href="{{ route('admin.grades.groups.create', $grade->id) }}"
           class="btn btn-primary">
            + Nuevo Grupo
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">

            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Capacidad</th>
                        <th>Matriculados</th>
                        <th>Disponibles</th>
                        <th>Estado</th>
                        <th width="220">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($groups as $group)
                    <tr>
                        <td>{{ $group->name }}</td>

                        <td>{{ $group->capacity }}</td>

                        <td>{{ $group->enrollments_count }}</td>

                        <td>
                            {{ $group->capacity - $group->enrollments_count }}
                        </td>

                        <td>
                            @if($group->status === 'activo')
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-secondary">Cerrado</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{route('admin.grades.groups.show', [$group->grade_id, $group->id])}}"
                               class="btn btn-sm btn-info">
                                Ver
                            </a>

                            <a href="{{route('admin.grades.groups.edit', [$group->grade_id, $group->id])}}"
                               class="btn btn-sm btn-warning">
                                Editar
                            </a>

                            <form action="{{ route('admin.grades.groups.destroy', [$group->grade_id, $group->id]) }}"
                                  method="POST"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Eliminar grupo?')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            No hay grupos registrados.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection