@extends('layouts.app')

@section('title', 'Estudiantes Egresados')
@push('styles')
@vite('resources/css/admin/enrollments/graduated.css')
@endpush
@section('content')

<div class="container">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>🎓 Estudiantes Egresados</h2>

        <a href="{{ route('admin.enrollments.index') }}" class="btn btn-secondary">
            ← Volver
        </a>
    </div>

    {{-- FILTROS --}}
    <div class="card mb-3 p-3">
        <form method="GET">
            <div class="row">

                {{-- BUSCAR POR APELLIDO --}}
                <div class="col-md-4">
                    <label>Buscar por apellido</label>
                    <input type="text" name="last_name" class="form-control"
                           value="{{ request('last_name') }}"
                           placeholder="Ej: Pérez">
                </div>

                {{-- FILTRAR POR AÑO --}}
                <div class="col-md-4">
                    <label>Filtrar por año</label>
                    <select name="year" class="form-control">
                        <option value="">Todos</option>

                        @foreach($years as $year)
                            <option value="{{ $year->year }}"
                                {{ request('year') == $year->year ? 'selected' : '' }}>
                                {{ $year->year }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- BOTONES --}}
                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button class="btn btn-primary">🔍 Buscar</button>

                    <a href="{{ route('admin.enrollments.graduated') }}" class="btn btn-secondary">
                        Limpiar
                    </a>
                </div>

            </div>
        </form>
    </div>

    {{-- TABLA --}}
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle mb-0">

                <thead class="table-dark text-center">
                    <tr>
                        <th>Estudiante</th>
                        <th>Año de Graduación</th>
                        <th>Grado</th>
                        <th>Grupo</th>
                        <th>Estado</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($enrollments as $enrollment)

                        <tr>

                            <td>
                                {{ $enrollment->student->first_name ?? '' }}
                                {{ $enrollment->student->last_name ?? '' }}
                            </td>

                            <td class="text-center">
                                {{ $enrollment->academicYear->year ?? '' }}
                            </td>

                            <td class="text-center">
                                {{ $enrollment->grade->name ?? '' }}
                            </td>

                            <td class="text-center">
                                {{ $enrollment->group->name ?? 'Sin grupo' }}
                            </td>

                            <td class="text-center">
                                <span class="badge bg-success">🎓 Egresados</span>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center">
                                No hay estudiantes Egresados registrados
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
                    <div class="mt-3">
            {{ $enrollments->links() }}
        </div>
        </div>
    </div>

</div>

@endsection