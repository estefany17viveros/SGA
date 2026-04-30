@extends('layouts.app')
@section('title', 'Años Académicos')
@push('styles')
@vite('resources/css/admin/academic_years/index.css')
@endpush
@section('content')<div class="container">

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

    {{-- BOTÓN CORREGIDO --}}
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('admin.academic_years.create') }}" class="btn btn-primary">
            Crear Nuevo Año
        </a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Año</th>
                <th>Calendario</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Trimestres</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
<tbody>
@forelse($academicYears as $year)
<tr>
    <td data-label="Año">{{ $year->year }}</td>
    <td data-label="Calendario">{{ $year->calendar }}</td>
    <td data-label="Inicio">
        {{ \Carbon\Carbon::parse($year->start_date)->format('d/m/Y') }}
    </td>
    <td data-label="Fin">
        {{ \Carbon\Carbon::parse($year->end_date)->format('d/m/Y') }}
    </td>
    <td data-label="Trimestres">{{ $year->periods }}</td>
    <td data-label="Estado">
        @if($year->status === 'activo')
            <span class="badge bg-success">Activo</span>
        @else
            <span class="badge bg-secondary">Cerrado</span>
        @endif
    </td>
    <td data-label="Acciones">
    <div class="action-group"> {{-- Contenedor Maestro --}}
        
        <a href="{{ route('admin.academic_years.show', $year->id) }}"
           class="btn btn-info btn-sm">
           Ver
        </a>

        @if($year->status === 'activo')
        <form action="{{ route('admin.academic_years.close', $year->id) }}"
              method="POST" class="d-inline"> {{-- d-inline es clave --}}
            @csrf
            @method('PUT')
            <button class="btn btn-dark btn-sm">Cerrar</button>
        </form>
        @endif

        <form action="{{ route('admin.academic_years.destroy', $year->id) }}"
              method="POST" class="d-inline"> {{-- d-inline es clave --}}
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm" 
                    onclick="return confirm('¿Estás seguro?')">
                Eliminar
            </button>
        </form>

    </div>
</td>
</tr>
@empty
<tr>
    <td colspan="7">No hay registros.</td>
</tr>
@endforelse
</tbody>
    </table>

    <div class="mt-3">
        {{ $academicYears->links() }}
    </div>

</div>
@endsection