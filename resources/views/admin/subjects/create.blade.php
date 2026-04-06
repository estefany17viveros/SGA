@extends('layouts.app')
@push('styles')
@vite('resources/css/subjects/create.css')
@endpush
@section('content')

<h1>➕ Crear Materia</h1>

@if($errors->any())
    <div style="color:red;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.subjects.store') }}">
    @csrf

    <div>
        <label>Nombre</label>
        <input type="text" name="name" value="{{ old('name') }}">
    </div>

    <div>
        <label>Descripción</label>
        <textarea name="description">{{ old('description') }}</textarea>
    </div>

    <br>

    <button>💾 Guardar</button>
</form>

<br>

<a href="{{ route('admin.subjects.index') }}">⬅ Volver</a>

@endsection