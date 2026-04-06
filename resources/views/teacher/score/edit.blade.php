@extends('layouts.app')

@section('title', 'Editar Nota')

@section('content')

<div class="container">
    <h2>✏️ Editar Nota</h2>

    <form action="{{ route('scores.update', $score->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Estudiante</label>
            <input type="text" class="form-control" value="{{ $score->student->name }}" disabled>
        </div>

        <div class="mb-3">
            <label>Nota</label>
            <input type="number" name="score" value="{{ $score->score }}" step="0.1" min="0" max="5" class="form-control">
        </div>

        <button class="btn btn-primary">Actualizar</button>
    </form>
</div>

@endsection