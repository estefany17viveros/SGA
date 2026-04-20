@extends('layouts.app')
@section('title', 'Grados')

@push('styles')
    @vite('resources/css/admin/grades/index.css')
@endpush

@section('content')
<div class="container">

    {{-- Título estilizado con la animación del CSS --}}
    <h2 class="mb-4">
        Lista de Grados
    </h2>

    {{-- Mensajes de Alerta --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- Cabecera de acciones --}}
    <div class="action-header mb-3">
        <a href="{{ route('admin.grades.create') }}" class="btn btn-primary">
            <span>+</span> Nuevo Grado
        </a>
    </div>

    {{-- Contenedor de tabla para manejar el radio de las esquinas --}}
    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Grado</th>
                    <th>Nivel</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($grades as $grade)
                <tr>
                    <td class="font-bold">{{ $grade->name }}</td>
                    <td>
                        <span class="badge-level">{{ $grade->level }}</span>
                    </td>

                    <td class="actions-cell">
                        <div class="btn-group-custom">
                            <a href="{{ route('admin.grades.show', $grade) }}"
                               class="btn btn-info btn-sm">
                                Ver
                            </a>

                            <a href="{{ route('admin.grades.edit', $grade) }}"
                               class="btn btn-warning btn-sm">
                                Editar
                            </a>

                            <a href="{{ route('admin.grades.groups.index', $grade->id) }}"
                               class="btn btn-primary btn-sm">
                                Grupos
                            </a>

                            <form action="{{ route('admin.grades.destroy', $grade) }}"
                                  method="POST"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('¿Eliminar este grado?')"
                                        class="btn btn-danger btn-sm">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="empty-state">
                        No hay grados registrados
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection