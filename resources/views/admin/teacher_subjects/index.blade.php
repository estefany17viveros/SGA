@extends('layouts.app')
@push('styles')
@vite('resources/css/admin/teachersubjects/index.css')
@endpush
@section('content')

<h2>Asignaciones</h2>

<a href="{{ route('admin.teacher-subjects.create') }}">Nueva Asignación</a>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>Profesor</th>
            <th>Materia</th>
            <th>Grado</th>
            <th>Grupo</th>
            <th>Año</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        @forelse($assignments as $a)
            <tr>
                <td>
                    {{ $a->teacher->first_name ?? 'Sin docente' }}
                    {{ $a->teacher->last_name ?? '' }}
                </td>

                <td>
                    {{ $a->subject->name ?? 'Sin materia' }}
                </td>

                <td>
                    {{ $a->grade->name ?? 'Sin grado' }}
                </td>

                <td>
                    {{ $a->group ? $a->group->name : 'General' }}
                </td>

                {{-- 🔥 AQUÍ ESTÁ LA CORRECCIÓN --}}
                <td>
                    {{ $a->academicYear ? $a->academicYear->year : 'Sin año' }}
                </td>

                <td>
                    <a href="{{ route('admin.teacher-subjects.show', $a->id) }}">Ver</a>

                    <a href="{{ route('admin.teacher-subjects.edit', $a->id) }}">Editar</a>

                    <form action="{{ route('admin.teacher-subjects.destroy', $a->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No hay registros</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection