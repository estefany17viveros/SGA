@extends('layouts.app')

@section('title', 'Estudiantes Retirados')
@push('styles')
@vite('resources/css/enrollments/retired.css')
@endpush
@section('content')

<div class="container">

<h2>Estudiantes Retirados</h2>

{{-- MENSAJES --}}
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

{{-- FILTROS --}}
<form method="GET" class="row mb-3">

    <div class="col-md-4">
        <input type="text" name="last_name" class="form-control"
            placeholder="Buscar por apellido"
            value="{{ request('last_name') }}">
    </div>

    <div class="col-md-4">
        <select name="year" class="form-control">
            <option value="">Todos los años</option>

            @foreach($years as $year)
                <option value="{{ $year->year }}"
                    {{ request('year') == $year->year ? 'selected' : '' }}>
                    {{ $year->year }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        <button class="btn btn-primary">Filtrar</button>
        <a href="{{ route('admin.enrollments.retired') }}" class="btn btn-secondary">
            Limpiar
        </a>
    </div>

</form>

{{-- TABLA --}}
<table class="table table-bordered">

    <thead>
        <tr>
            <th>Estudiante</th>
            <th>Año</th>
            <th>Grado</th>
            <th>Grupo</th>
            <th>Estado</th>
        </tr>
    </thead>

    <tbody>

        @forelse($enrollments as $enrollment)

            <tr>

                <td>
                    {{ $enrollment->student->first_name }}
                    {{ $enrollment->student->last_name }}
                </td>

                <td>
                    {{ $enrollment->academicYear->year }}
                </td>

                <td>
                    {{ $enrollment->grade->name }}
                </td>

                <td>
                    {{ $enrollment->group->name ?? 'Sin grupo' }}
                </td>

                <td>
                    <span class="badge bg-danger">
                        🚫 Retirado
                    </span>
                </td>

            </tr>

        @empty

            <tr>
                <td colspan="5">No hay estudiantes retirados</td>
            </tr>

        @endforelse

    </tbody>

</table>

{{-- PAGINACIÓN --}}
<div class="mt-3">
    {{ $enrollments->links() }}
</div>

</div>

@endsection