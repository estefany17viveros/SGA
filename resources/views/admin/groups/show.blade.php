@extends('layouts.app')
@section('title', 'Detalle del Grupo')
@push('styles')
@vite('resources/css/groups/show.css')
@endpush
@section('content')
<div class="container">

    <h4 class="mb-3">
        Detalle del Grupo {{ $group->name }}
    </h4>

    <div class="card">
        <div class="card-body">

            <p><strong>Grado:</strong> {{ $group->grade->name }}</p>
            <p><strong>Capacidad:</strong> {{ $group->capacity }}</p>
            <p><strong>Matriculados:</strong> {{ $group->enrollments_count }}</p>
            <p><strong>Estado:</strong> {{ ucfirst($group->status) }}</p>

           <a href="{{ route('admin.grades.groups.edit', [$grade->id, $group->id]) }}"
               class="btn btn-warning">
                Editar
            </a>

          <a href="{{ route('admin.grades.groups.index', $grade->id) }}"
               class="btn btn-secondary">
                Volver
            </a>

        </div>
    </div>

</div>
@endsection