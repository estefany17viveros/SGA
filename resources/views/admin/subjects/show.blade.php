@extends('layouts.app')
@push('styles')
@vite('resources/css/admin/subjects/show.css')
@endpush
@section('content')

<h1>📄 Detalle de Materia</h1>

<div style="border:1px solid #ccc; padding:20px; border-radius:10px;">

    <p><strong>ID:</strong> {{ $subject->id }}</p>

    <p><strong>Nombre:</strong> {{ $subject->name }}</p>

    <p><strong>Descripción:</strong> 
        {{ $subject->description ?? 'Sin descripción' }}
    </p>

    <p><strong>Estado:</strong> 
        @if($subject->status == 'active')
            <span style="color:green;">Activo</span>
        @else
            <span style="color:red;">Inactivo</span>
        @endif
    </p>

    <p><strong>Creado:</strong> {{ $subject->created_at->format('d/m/Y') }}</p>

</div>

<br>

<a href="{{ route('admin.subjects.index') }}">⬅ Volver</a>
<a href="{{ route('admin.subjects.edit', $subject) }}">✏️ Editar</a>

@endsection