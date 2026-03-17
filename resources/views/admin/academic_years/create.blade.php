@extends('layouts.app')
@section('title', 'Crear Año Académico')
@push('styles')
@vite('resources/css/academic_years/create.css')
@endpush
@section('content')
<div class="container">

    <h2>Crear Año Académico</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.academic_years.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Año</label>
            <input type="number" name="year"
                   class="form-control"
                   value="{{ old('year') }}"
                   required>
        </div>

        <div class="mb-3">
            <label>Calendario</label>
            <select name="calendar" class="form-control" required>
                <option value="">Seleccione</option>
                <option value="A" {{ old('calendar') == 'A' ? 'selected' : '' }}>A (Enero - Diciembre)</option>
                <option value="B" {{ old('calendar') == 'B' ? 'selected' : '' }}>B (Julio - Junio)</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Períodos Académicos</label>
            <input type="number" name="periods"
                   class="form-control"
                   value="{{ old('periods') }}"
                   required>
        </div>

        <button class="btn btn-success">Guardar</button>
        <a href="{{ route('admin.academic_years.index') }}" class="btn btn-secondary">
            Cancelar
        </a>

    </form>

</div>
@endsection