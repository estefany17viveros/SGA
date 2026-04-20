@extends('layouts.app')
@section('title', 'Crear Grado')
@push('styles')
@vite('resources/css/admin/grades/edit.css')
@endpush
@section('content')
<div class="container">

    <h2>Editar Grado</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.grades.update',$grade) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="mb-3">

            <label class="form-label">Grado</label>

            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name',$grade->name) }}"
                   required>

        </div>

        <div class="mb-3">

            <label class="form-label">Nivel</label>

            <input type="number"
                   name="level"
                   class="form-control"
                   value="{{ old('level',$grade->level) }}"
                   required>

        </div>
<div>
    <label for="director_id">Director de grupo</label>

    <select name="director_id" id="director_id" class="mt-1 block w-full border rounded p-2">

        <option value="">-- Sin director --</option>

        @foreach($teachers as $teacher)
            <option value="{{ $teacher->id }}"
                {{ $grade->director_id == $teacher->id ? 'selected' : '' }}>
                
                {{ $teacher->full_name }}
            </option>
        @endforeach

    </select>
</div>
        <button class="btn btn-primary">
            Actualizar
        </button>

        <a href="{{ route('admin.grades.index') }}"
           class="btn btn-secondary">
           Cancelar
        </a>

    </form>

</div>
@endsection