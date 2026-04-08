@extends('layouts.app')
@section('title', 'Grados')
@push('styles')
@vite('resources/css/admin/grades/index.css')
@endpush
@section('content')
<div class="container">

    <h2 class="mb-4">
        Lista de Grados
    </h2>

    {{-- Mensajes --}}
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

    <a href="{{ route('admin.grades.create') }}" class="btn btn-primary mb-3">
        + Nuevo Grado
    </a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Grado</th>
                <th>Nivel</th>
                <th width="250">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse($grades as $grade)
            <tr>
                <td>{{ $grade->name }}</td>
                <td>{{ $grade->level }}</td>

                <td>

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

                    <form action="{{ route('admin.grades.destroy',$grade) }}"
                          method="POST"
                          class="d-inline">

                        @csrf
                        @method('DELETE')

                        <button onclick="return confirm('¿Eliminar este grado?')"
                                class="btn btn-danger btn-sm">
                            Eliminar
                        </button>

                    </form>

                </td>
            </tr>

            @empty
            <tr>
                <td colspan="3" class="text-center">
                    No hay grados registrados
                </td>
            </tr>
            @endforelse

        </tbody>
    </table>

</div>
@endsection