@extends('layouts.app')

@push('styles')
    @vite('resources/css/teacher/grades.css')
@endpush

@section('content')

<div class="container">

    <h2>🎓 Grados</h2>

    <a href="{{ route('teacher.dashboard') }}">⬅ Volver</a>

    <div class="grid">

        @forelse($grades as $grade)

            <div class="card">

                <h3>{{ $grade['grade_name'] }}</h3>

                <a href="{{ route('teacher.subject.students', [$subjectId, $grade['grade_id']]) }}" class="btn">
                    Ver estudiantes
                </a>

            </div>

        @empty
            <p>No hay grados asignados.</p>
        @endforelse

    </div>

</div>

@endsection