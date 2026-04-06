@extends('layouts.app')

@section('title', 'Detalle de Notas')

@section('content')

<div class="container">
    <h2>📋 Notas de la Actividad</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Nota</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($scores as $score)
                <tr>
                    <td>{{ $score->student->name }}</td>
                    <td>{{ $score->score }}</td>
                    <td>
                        <a href="{{ route('scores.edit', $score->id) }}" class="btn btn-warning btn-sm">Editar</a>

                        <form action="{{ route('scores.destroy', $score->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection