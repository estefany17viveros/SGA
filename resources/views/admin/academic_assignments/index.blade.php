@extends('layouts.app')

@section('content')

<h1>Asignaciones Académicas</h1>

<a href="{{ route('academic-assignments.create') }}">➕ Nueva</a>

<table border="1" cellpadding="10">
    <tr>
        <th>Grado</th>
        <th>Grupo</th>
        <th>Materia</th>
        <th>Año</th>
        <th>Acciones</th>
    </tr>

    @foreach($assignments as $a)
    <tr>
        <td>{{ $a->grade->name }}</td>
        <td>{{ $a->group->name }}</td>
        <td>{{ $a->subject->name }}</td>
        <td>{{ $a->academicYear->name ?? '' }}</td>

        <td>
            <a href="{{ route('academic-assignments.show', $a) }}">Ver</a>
            <a href="{{ route('academic-assignments.edit', $a) }}">Editar</a>

            <form action="{{ route('academic-assignments.destroy', $a) }}" method="POST">
                @csrf
                @method('DELETE')
                <button>Eliminar</button>
            </form>
        </td>
    </tr>
    @endforeach

</table>

{{ $assignments->links() }}

@endsection