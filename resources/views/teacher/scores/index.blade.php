@extends('layouts.app')

@section('content')

<div class="container">

    {{-- 🔥 TÍTULO --}}
    <div class="mb-4">
        <h2>📊 Registro de Notas</h2>
        <h4>
            {{ $assignment->subject->name }} - {{ $assignment->grade->name }}
        </h4>
    </div>

    {{-- ✅ MENSAJES --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- 📥 FORMULARIO --}}
    <form action="{{ route('teacher.scores.store') }}" method="POST">
        @csrf

        <input type="hidden" name="teacher_subject_id" value="{{ $assignment->id }}">

        <div class="table-responsive">
            <table class="table table-bordered table-hover">

                {{-- 🔥 CABECERA --}}
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Estudiante</th>
                        <th>Saber</th>
                        <th>Hacer</th>
                        <th>Ser</th>
                        <th>Comentario</th>
                    </tr>
                </thead>

                {{-- 🔥 CUERPO --}}
                <tbody>

                    @forelse($students as $student)

                        @php
                            $score = $scores[$student->id] ?? null;
                        @endphp

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <strong>{{ $student->full_name }}</strong>
                            </td>

                            {{-- SABER --}}
                            <td>
                                <input 
                                    type="number"
                                    step="0.1"
                                    min="0"
                                    max="5"
                                    name="scores[{{ $student->id }}][saber]"
                                    value="{{ $score->saber ?? '' }}"
                                    class="form-control"
                                    placeholder="0.0">
                            </td>

                            {{-- HACER --}}
                            <td>
                                <input 
                                    type="number"
                                    step="0.1"
                                    min="0"
                                    max="5"
                                    name="scores[{{ $student->id }}][hacer]"
                                    value="{{ $score->hacer ?? '' }}"
                                    class="form-control"
                                    placeholder="0.0">
                            </td>

                            {{-- SER --}}
                            <td>
                                <input 
                                    type="number"
                                    step="0.1"
                                    min="0"
                                    max="5"
                                    name="scores[{{ $student->id }}][ser]"
                                    value="{{ $score->ser ?? '' }}"
                                    class="form-control"
                                    placeholder="0.0">
                            </td>

                            {{-- COMENTARIO --}}
                            <td>
                                <input 
                                    type="text"
                                    name="scores[{{ $student->id }}][comment]"
                                    value="{{ $score->comment ?? '' }}"
                                    class="form-control"
                                    placeholder="Comentario">
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                No hay estudiantes en este grado
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

        {{-- 🔥 BOTÓN --}}
        <div class="mt-3">
            <button class="btn btn-success">
                💾 Guardar Notas
            </button>
        </div>

    </form>

</div>

@endsection