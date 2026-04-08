@extends('layouts.app')
@push('styles')
@vite('resources/css/admin/subjects/edit.css')
@endpush
@section('content')

<h1>✏️ Editar Materia</h1>

@if($errors->any())
    <div style="color:red;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.subjects.update', $subject) }}">
    @csrf
    @method('PUT')

    <div>
        <label>Nombre</label>
        <input type="text" name="name" value="{{ $subject->name }}">
    </div>

    <div>
        <label>Descripción</label>
        <textarea name="description">{{ $subject->description }}</textarea>
    </div>

    <div>
        <label>Estado</label>
        <select name="status">
            <option value="active" {{ $subject->status == 'active' ? 'selected' : '' }}>Activo</option>
            <option value="inactive" {{ $subject->status == 'inactive' ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>

    <br>

    <button>🔄 Actualizar</button>
</form>

<br>

<a href="{{ route('admin.subjects.index') }}">⬅ Volver</a>

@endsection