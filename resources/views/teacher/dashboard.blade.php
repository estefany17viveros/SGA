@extends('layouts.app')

@push('styles')
    @vite('resources/css/teacher/dashboard.css')
@endpush

@section('content')

<div class="container">

    <h2>📚 Mis materias</h2>

    <div class="grid">

        @foreach($data as $subject)

            <div class="card">

                <h3>{{ $subject['subject'] }}</h3>

                <a href="{{ route('teacher.subject.grades', $subject['subject_id']) }}" class="btn">
                    Ver grados
                </a>

            </div>

        @endforeach

    </div>

</div>

@endsection