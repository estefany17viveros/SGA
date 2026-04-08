@extends('layouts.app')
@push('styles')
@vite('resources/css/admin/subjects/index.css')
@endpush
@section('content')

<h1>Listado de Materias</h1>

<a href="{{ route('admin.subjects.create') }}">Crear nueva materia</a>

<br><br>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<form method="GET">
    <input type="text" name="search" placeholder="Buscar..." value="{{ request('search') }}">
    <button type="submit">Buscar</button>
</form>

<br>

<table border="1" cellpadding="10">
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
                    <a href="{{ route('admin.subjects.show', $subject) }}">Ver</a> |
                    <a href="{{ route('admin.subjects.edit', $subject) }}">Editar</a> |

                    <form action="{{ route('admin.subjects.destroy', $subject) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Eliminar</button>
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

<br>

{{ $subjects->links() }}

@endsection