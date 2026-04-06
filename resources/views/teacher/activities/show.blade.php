@extends('layouts.app')

@section('title', 'Detalle Actividad')

@section('content')

<div class="container">
    <h2>📄 Detalle de Actividad</h2>

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Descripción:</strong> {{ $activity->description }}</p>
            <p><strong>Tipo:</strong> {{ $activity->type }}</p>
            <p><strong>Porcentaje:</strong> {{ $activity->percentage }}%</p>
        </div>
    </div>

    <h4>📊 Notas</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Nota</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activity->scores as $score)
                <tr>
                    <td>{{ $score->student->name }}</td>
                    <td>{{ $score->score }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('teacher.activities.index') }}" class="btn btn-secondary">
        Volver
    </a>

</div>

@endsection