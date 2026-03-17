@extends('layouts.app')
@section('title', 'Años Académicos')
@push('styles')
@vite('resources/css/academic_years/index.css')
@endpush
@section('content')
<div class="container">

    <h2>Años Académicos</h2>

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

    <a href="{{ route('admin.academic_years.create') }}" class="btn btn-primary mb-3">
        Crear Nuevo Año
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Año</th>
                <th>Calendario</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Períodos</th>
                <th>Estado</th>
                <th width="250">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($academicYears as $year)
                <tr>
                    <td>{{ $year->year }}</td>
                    <td>{{ $year->calendar }}</td>
                    <td>{{ \Carbon\Carbon::parse($year->start_date)->format('d/m/Y') }}</td>
<td>{{ \Carbon\Carbon::parse($year->end_date)->format('d/m/Y') }}</td>
                    <td>{{ $year->periods }}</td>
                    <td>
                        @if($year->status === 'activo')
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-secondary">Cerrado</span>
                        @endif
                    </td>
                    <td>

                        <a href="{{ route('admin.academic_years.show', $year->id) }}"
                           class="btn btn-info btn-sm">Ver</a>

                        <a href="{{ route('admin.academic_years.edit', $year->id) }}"
                           class="btn btn-warning btn-sm">Editar</a>

                        @if($year->status === 'activo')
                            <form action="{{ route('admin.academic_years.close', $year->id) }}"
                                  method="POST"
                                  style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-dark btn-sm">
                                    Cerrar
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('admin.academic_years.destroy', $year->id) }}"
                              method="POST"
                              style="display:inline;"
                              onsubmit="return confirm('¿Seguro que deseas eliminar este año?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                Eliminar
                            </button>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No hay registros.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection