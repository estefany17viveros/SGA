@extends('layouts.app')

@section('title', 'Notas')

@section('content')

<div class="container">
    <h2>📊 Gestión de Notas</h2>

    {{-- MENSAJES --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- FORMULARIO MASIVO --}}
    <form action="{{ route('scores.store') }}" method="POST">
        @csrf

        <input type="hidden" name="activity_id" value="{{ $activity->id }}">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Nota (0 - 5)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $index => $student)
                    <tr>
                        <td>
                            {{ $student->name }}
                            <input type="hidden" name="scores[{{ $index }}][student_id]" value="{{ $student->id }}">
                        </td>
                        <td>
                            <input 
                                type="number" 
                                step="0.1" 
                                name="scores[{{ $index }}][score]" 
                                class="form-control"
                                min="0" 
                                max="5"
                                value="{{ $student->score ?? '' }}"
                            >
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button class="btn btn-success">💾 Guardar Notas</button>
    </form>

</div>

@endsection 