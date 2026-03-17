@extends('layouts.app')
@section('title', 'Crear Año Académico')
@push('styles')
@vite('resources/css/academic_years/create.css')
@endpush
@section('content')
<div class="container">

    <h2>Editar Año Académico</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.academic_years.update', $academicYear->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Año</label>
            <input type="number"
                   name="year"
                   class="form-control"
                   value="{{ old('year', $academicYear->year) }}"
                   required>
        </div>

          <div class="mb-3">
            <label>Calendario</label>
           <select name="calendar" class="form-control" disabled>
    <option value="A" {{ $academicYear->calendar == 'A' ? 'selected' : '' }}>A</option>
    <option value="B" {{ $academicYear->calendar == 'B' ? 'selected' : '' }}>B</option>
</select>

<input type="hidden" name="calendar" value="{{ $academicYear->calendar }}">
        </div>

        <div class="mb-3">
            <label>Períodos Académicos</label>
            <input type="number"
                   name="periods"
                   class="form-control"
                   value="{{ old('periods', $academicYear->periods) }}"
                   required>
        </div>

        <button class="btn btn-primary">Actualizar</button>
        <a href="{{ route('admin.academic_years.index') }}" class="btn btn-secondary">
            Cancelar
        </a>

    </form>

</div>
@endsection