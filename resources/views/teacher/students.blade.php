@extends('layouts.app')

@push('styles')
    @vite('resources/css/teacher/students.css')
@endpush

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>👨‍🎓 Estudiantes</h2>

        {{-- 🔥 BOTÓN GLOBAL --}}
        <a href="{{ route('teacher.scores.index', $teacher_subject_id) }}" class="btn btn-primary">
            📊 Gestionar Notas
        </a>
    </div>

    <a href="{{ route('teacher.dashboard') }}">⬅ Volver al inicio</a>

    <div class="table-responsive mt-3">
        <table class="table table-bordered">

            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Saber</th>
                    <th>Hacer</th>
                    <th>Ser</th>
                    <th>Comentario</th>
                </tr>
            </thead>

            <tbody>

                @forelse($students as $student)

                    @php
                        $score = $student->scores
                            ->where('teacher_subject_id', $teacher_subject_id)
                            ->first();
                    @endphp

                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $student->full_name }}</td>

                        {{-- SABER --}}
                        <td>
                            <span class="badge bg-secondary">
                                {{ $score->saber ?? '-' }}
                            </span>
                        </td>

                        {{-- HACER --}}
                        <td>
                            <span class="badge bg-secondary">
                                {{ $score->hacer ?? '-' }}
                            </span>
                        </td>

                        {{-- SER --}}
                        <td>
                            <span class="badge bg-secondary">
                                {{ $score->ser ?? '-' }}
                            </span>
                        </td>

                        {{-- COMENTARIO --}}
                        <td>
                            {{ $score->comment ?? 'Sin comentario' }}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center">
                            No hay estudiantes
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>
    </div>

</div>

@endsection