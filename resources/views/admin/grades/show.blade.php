@extends('layouts.app')
@section('title', 'Detalle del Grado')
@push('styles')
@vite('resources/css/admin/grades/show.css')
@endpush
@section('content')
<div class="container">

    <h2>Detalle del Grado</h2>

    <div class="card">
        <div class="card-body">
            
            <p><strong>Grado:</strong> {{ $grade->name }}</p>

            <p><strong>Nivel:</strong> {{ $grade->level }}</p>

            <p><strong>Creado:</strong>
                {{ $grade->created_at->format('d/m/Y') }}
            </p>

        </div>
    </div>

    <a href="{{ route('admin.grades.index') }}"
       class="btn btn-secondary mt-3">
        Volver
    </a>

</div>
@endsection