@extends('layouts.app')

@section('title', 'Editar Actividad')

@section('content')

<div class="container">
    <h2>✏️ Editar Actividad</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('activities.update', $activity->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Descripción</label>
            <input type="text" name="description" value="{{ $activity->description }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Porcentaje</label>
            <input type="number" name="percentage" value="{{ $activity->percentage }}" class="form-control">
        </div>

        <button class="btn btn-primary">Actualizar</button>
    </form>
</div>

@endsection