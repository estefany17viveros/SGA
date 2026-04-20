@extends('layouts.app')
@section('title', 'Estudiantes del grado')
@push('styles')
    @vite('resources/css/teacher/director/student.css')
@endpush
@section('content')
<div class="container">

    <h2>👨‍🎓 Estudiantes del grado: {{ $grade->name ?? '' }}</h2>

    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm mb-3">
        ⬅ Volver
    </a>

    @if($students->isEmpty())
        <div class="alert alert-warning text-center">
            No hay estudiantes en este grado
        </div>
    @else
<form method="GET" class="mb-3">

    <div style="display:flex; gap:10px; flex-wrap:wrap;">

        <input type="text" name="name" placeholder="Nombre"
            value="{{ request('name') }}"
            class="form-control" style="max-width:200px;">

        <input type="text" name="last_name" placeholder="Apellido"
            value="{{ request('last_name') }}"
            class="form-control" style="max-width:200px;">

        <button type="submit" class="btn btn-primary btn-sm">
            🔍 Buscar
        </button>

        <a href="{{ route('teacher.director.students', $grade->id) }}"
           class="btn btn-secondary btn-sm">
            ❌ Limpiar
        </a>

    </div>

</form>
        <table class="table table-bordered table-hover">

            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Acción</th>
                </tr>
            </thead>

            <tbody>

                @foreach($students as $i => $student)
                    <tr>
                        <td>{{ $i + 1 }}</td>

                        <td>
                            {{ $student->first_name }} {{ $student->last_name }}
                        </td>

                        <td>
                            {{ $student->identification_number }}
                        </td>

                        <td>
                            <a href="{{ route('teacher.students.show', $student->id) }}"
                               class="btn btn-info btn-sm">
                                👁 Ver
                            </a>
                        </td>
                    </tr>
                @endforeach

            </tbody>

        </table>

    @endif

</div>
@endsection