@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-8">

    <h2 class="text-2xl font-bold mb-4">
        📊 Notas - {{ $activity->description }}
    </h2>

    <div class="bg-white shadow rounded-lg p-6">

        <p><strong>Tipo:</strong> 
            <span class="px-2 py-1 rounded 
                @if($activity->type == 'saber') bg-blue-200 
                @elseif($activity->type == 'hacer') bg-green-200 
                @else bg-pink-200 
                @endif">
                {{ ucfirst($activity->type) }}
            </span>
        </p>

        <p><strong>Porcentaje:</strong> {{ $activity->percentage }}%</p>

        <hr class="my-4">

        <form method="POST" action="{{ route('teacher.scores.store') }}">
            @csrf

            <input type="hidden" name="activity_id" value="{{ $activity->id }}">

            <table class="w-full border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">#</th>
                        <th class="p-2 border">Estudiante</th>
                        <th class="p-2 border">Nota (0 - 5)</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($activity->scores as $score)
                        <tr>
                            <td class="p-2 border">{{ $loop->iteration }}</td>

                            <td class="p-2 border">
                                {{ $score->student->first_name }} 
                                {{ $score->student->last_name }}
                            </td>

                            <td class="p-2 border">
                                <input 
                                    type="number"
                                    step="0.1"
                                    min="0"
                                    max="5"
                                    name="scores[{{ $loop->index }}][score]"
                                    value="{{ $score->score }}"
                                    class="w-20 border rounded px-2 py-1"
                                >

                                <input 
                                    type="hidden"
                                    name="scores[{{ $loop->index }}][student_id]"
                                    value="{{ $score->student_id }}"
                                >
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    💾 Guardar notas
                </button>
            </div>

        </form>

    </div>

</div>

@endsection