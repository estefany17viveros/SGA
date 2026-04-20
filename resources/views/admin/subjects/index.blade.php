@extends('layouts.app')
@push('styles')
@vite('resources/css/admin/subjects/index.css')
@endpush
@section('content')
<div class="subjects-index-page">

    <h1>Listado de Materias</h1>

    <a href="{{ route('admin.subjects.create') }}" class="btn-create">
        Crear nueva materia
    </a>

    @if(session('success'))
        <p class="alert-success">{{ session('success') }}</p>
    @endif

    <form method="GET" class="search-form">
        <input type="text" name="search" placeholder="Buscar..." value="{{ request('search') }}">
        <button type="submit">Buscar</button>
    </form>

    <table class="subjects-table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subjects as $subject)
                <tr>
                    <td>{{ $subject->name }}</td>
                    <td>{{ $subject->description }}</td>
                    <td>
                        <a href="{{ route('admin.subjects.show', $subject) }}" class="btn-view">Ver</a>
                        <a href="{{ route('admin.subjects.edit', $subject) }}" class="btn-edit">Editar</a>

                        <form action="{{ route('admin.subjects.destroy', $subject) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No hay materias</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $subjects->links() }}

</div>
@endsection