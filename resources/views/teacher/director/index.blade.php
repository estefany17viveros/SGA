@extends('layouts.app')

@section('content')
<div class="container">

    <h2>📘 Mis grupos como director</h2>

    {{-- 🔵 GRUPOS ASIGNADOS --}}
    @forelse($grades as $grade)
        <div class="card p-3 mb-2">
            <strong>{{ $grade->name }}</strong>

            <a href="{{ route('teacher.director.students', $grade->id) }}"
               class="btn btn-primary btn-sm mt-2">
                Ver estudiantes
            </a>
        </div>
    @empty
        <p>No tienes grupos asignados</p>
    @endforelse


    <hr>

    {{-- 🟡 OTROS ESTUDIANTES --}}
    <h3>📚 Estudiantes de otros grados</h3>

    <div class="card p-3 mb-3">

        {{-- 🔍 FILTROS --}}
        <form method="GET" class="row mb-3">

            <div class="col-md-4">
                <input type="text" name="name"
                       class="form-control"
                       placeholder="Nombre"
                       value="{{ request('name') }}">
            </div>

            <div class="col-md-4">
                <input type="text" name="last_name"
                       class="form-control"
                       placeholder="Apellido"
                       value="{{ request('last_name') }}">
            </div>

            <div class="col-md-4">
                <select name="grade_id" class="form-control">
                    <option value="">-- Todos los grados --</option>
                    @foreach($grades as $grade)
                        <option value="{{ $grade->id }}"
                            {{ request('grade_id') == $grade->id ? 'selected' : '' }}>
                            {{ $grade->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-12 mt-2">
                <button class="btn btn-primary w-100">
                    🔍 Filtrar
                </button>
            </div>

        </form>

        {{-- 📋 TABLA --}}
        <table class="table table-bordered">

            <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Grado</th>
                    <th>Documento</th>
                    <th>Acción</th>
                </tr>
            </thead>

            <tbody>

                @forelse($allStudents as $student)

                    <tr>
                        <td>
                            {{ $student->first_name }} {{ $student->last_name }}
                        </td>

                        <td>
                            {{ $student->enrollments->first()->grade->name ?? 'Sin grado' }}
                        </td>

                        <td>
                            {{ $student->identification_number }}
                        </td>

                        <td>
                           <a href="{{ route('teacher.students.show', $student->id) }}"
   class="btn btn-info btn-sm">
    Ver información
</a>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            No hay estudiantes para mostrar
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>

        {{-- 📄 PAGINACIÓN --}}
        <div class="mt-3">
            {{ $allStudents->appends(request()->all())->links() }}
        </div>

    </div>

</div>
@endsection