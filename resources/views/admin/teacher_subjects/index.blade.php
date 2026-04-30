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
                    <th>Año actual</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($assignments as $group)

                    @php
                        $a = $group->first();

                        $activeYear = $group->firstWhere('academicYear.status', 'activo');
                    @endphp

                    <tr>
                        <td>
                            <strong>{{ $a->teacher->first_name ?? '' }}</strong>
                            {{ $a->teacher->last_name ?? '' }}
                        </td>

                        <td>{{ $a->subject->name ?? '' }}</td>

                        <td>{{ $a->grade->name ?? '' }}</td>

                        <td>{{ $a->group ? $a->group->name : 'General' }}</td>

                        <td>
                            {{ $activeYear->academicYear->year ?? 'Sin año activo' }}
                        </td>

                        <td class="actions-cell">

                            {{-- HISTORIAL --}}
                            <a href="{{ route('admin.teacher-subjects.history', $a->id) }}" class="btn-action show" title="Historial">
                                📅
                            </a>

                            {{-- EDITAR --}}
                            <a href="{{ route('admin.teacher-subjects.edit', $a->id) }}" class="btn-action edit" title="Editar">
                                ✏️
                            </a>

                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6">No hay registros</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection