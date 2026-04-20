@extends('layouts.app')

@push('styles')
    @vite('resources/css/admin/teachersubjects/index.css')
@endpush

@section('content')

<div class="container">
    <h2>Asignaciones</h2>

    <div class="header-actions">
        <a href="{{ route('admin.teacher-subjects.create') }}" class="btn-create">
            <span>+</span> Nueva Asignación
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="table-wrap">
        <table>
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
                        <td data-label="Profesor">
                            <strong>{{ $a->teacher->first_name ?? 'Sin docente' }}</strong>
                            <span>{{ $a->teacher->last_name ?? '' }}</span>
                        </td>

                        <td data-label="Materia">
                            {{ $a->subject->name ?? 'Sin materia' }}
                        </td>

                        <td data-label="Grado">
                            <span class="badge-info">{{ $a->grade->name ?? 'Sin grado' }}</span>
                        </td>

                        <td data-label="Grupo">
                            {{ $a->group ? $a->group->name : 'General' }}
                        </td>

                        <td data-label="Año">
                            {{ $a->academicYear ? $a->academicYear->year : 'Sin año' }}
                        </td>

                        <td data-label="Acciones" class="actions-cell">
                            <a href="{{ route('admin.teacher-subjects.show', $a->id) }}" class="btn-action show" title="Ver">
                                👁️
                            </a>

                            <a href="{{ route('admin.teacher-subjects.edit', $a->id) }}" class="btn-action edit" title="Editar">
                                ✏️
                            </a>

                            <form action="{{ route('admin.teacher-subjects.destroy', $a->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" onclick="return confirm('¿Estás seguro de eliminar esta asignación?')" title="Eliminar">
                                    🗑️
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-row">No hay registros encontrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection