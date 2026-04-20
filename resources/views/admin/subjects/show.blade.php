@extends('layouts.app')

@push('styles')
    @vite('resources/css/admin/subjects/show.css')
@endpush

@section('content')

<div class="subject-show-page">

    <h1>Detalle de Materia</h1>

    {{-- Usamos la clase 'card' que limpiamos en el CSS para que se vea sobre el fondo blanco --}}
    <div class="card">
        <p><strong>ID:</strong> {{ $subject->id }}</p>

        <p><strong>Nombre:</strong> {{ $subject->name }}</p>

        <p>
            <strong>Descripción:</strong> 
            {{ $subject->description ?? 'Sin descripción' }}
        </p>

        <p>
            <strong>Estado:</strong> 
            @if($subject->status == 'active')
                <span class="status active">Activo</span>
            @else
                <span class="status inactive">Inactivo</span>
            @endif
        </p>

        <p>
            <strong>Creado:</strong> 
            {{ $subject->created_at->format('d/m/Y') }}
        </p>
    </div>

    {{-- Los botones ahora tienen las clases que activan los colores del CSS --}}
    <div class="actions">
        <a href="{{ route('admin.subjects.index') }}" class="btn-action btn-back">
            ⬅ Volver
        </a>
        
        <a href="{{ route('admin.subjects.edit', $subject) }}" class="btn-action btn-edit">
            ✏️ Editar Materia
        </a>
    </div>

</div>

@endsection