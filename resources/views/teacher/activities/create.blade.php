@extends('layouts.app')

@section('title', 'Crear Actividad')

@section('content')

<div class="container">
    <h2>➕ Crear Actividad</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('activities.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Materia</label>
            <input type="number" name="subject_id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Grupo</label>
            <input type="number" name="group_id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Periodo</label>
            <input type="number" name="period_id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Tipo</label>
            <select name="type" class="form-control">
                <option value="saber">Saber</option>
                <option value="hacer">Hacer</option>
                <option value="ser">Ser</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Descripción</label>
            <input type="text" name="description" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Porcentaje</label>
            <input type="number" name="percentage" class="form-control" required>
        </div>

        <button class="btn btn-success">Guardar</button>
    </form>
</div>

@endsection