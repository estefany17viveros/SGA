@extends('layouts.app')
@push('styles')
@vite('resources/css/admin/subjects/create.css')
@endpush
@section('content')
<div class="create-subject-page">

    <h1>Crear Materia</h1>

    @if($errors->any())
        <div class="error-box">
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

        <button type="submit">💾 Guardar</button>
    </form>

    <a href="{{ route('admin.subjects.index') }}">⬅ Volver</a>

</div>
@endsection