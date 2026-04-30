@extends('layouts.app')

@push('styles')
    @vite('resources/css/admin/teachersubjects/history.css')
@endpush

@section('content')
<div class="container">

    <h3>📅 Historial de años</h3>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Año</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>
                @forelse($history as $h)
                    <tr>
                        <td data-label="Año">
                            {{ $h->academicYear->year }}
                        </td>
                        <td data-label="Estado">
                            @php
                                $status = strtolower($h->academicYear->status);
                                $badgeClass = match($status) {
                                    'activo'   => 'badge-activo',
                                    'cerrado'  => 'badge-cerrado',
                                    default    => 'badge-inactivo',
                                };
                            @endphp
                            <span class="badge-estado {{ $badgeClass }}">
                                {{ $h->academicYear->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="empty-row">
                            No hay registros en el historial.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <a href="{{ route('admin.teacher-subjects.index') }}" class="btn btn-secondary">
        ← Volver
    </a>

</div>
@endsection