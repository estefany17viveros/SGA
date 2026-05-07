@extends('layouts.app')

@push('styles')
    @vite('resources/css/teacher/dashboard.css')
@endpush

@section('content')

<div class="container">

    {{-- =========================
        📚 MIS ASIGNATURAS
    ========================== --}}
    <h2>📚 Mis Asignaturas</h2>

    <div class="grid">

        @forelse($data as $subject)

            <div class="card">

                <h3>
                    {{ $subject['subject'] ?? 'Sin materia' }}
                </h3>

                <a href="{{ route('teacher.subject.grades', $subject['subject_id']) }}" class="btn">
                    Ver grados
                </a>

            </div>

        @empty

            <div class="empty-state">
                <p>No tienes asignaturas asignadas.</p>
            </div>

        @endforelse

    </div>


    {{-- =========================
        🔥 DIRECTOR DE GRUPO
    ========================== --}}
    @if(isset($directorGrades) && $directorGrades->count() > 0)

        <hr class="section-divider">

        <h2>📌 Dirección de grupo</h2>

        <div class="grid">

            @foreach($directorGrades as $grade)

                <div class="card director-card">

                    <h3>👩‍🏫 Director de grupo</h3>

                    <p>
                        <strong>Grado:</strong> {{ $grade->name }}
                    </p>

                    {{-- 👨‍🎓 VER ESTUDIANTES + NOTA --}}
                    <a href="{{ route('teacher.director.students', $grade->id) }}" class="btn btn-primary">
                        👨 Disciplina y Comportamiento
                    </a>

                </div>

            @endforeach

        </div>

    @else

        <div class="empty-state">
            <p>No eres director de ningún grado.</p>
        </div>

    @endif

</div>

@endsection