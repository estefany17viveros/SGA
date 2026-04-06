<form action="{{ route('teacher.scores.store') }}" method="POST">
    @csrf

    <input type="hidden" name="activity_id" value="{{ $activity->id }}">

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Nota</th>
            </tr>
        </thead>
        <tbody>

            @foreach($students as $index => $student)

                @php
                    $score = \App\Models\Score::where('activity_id', $activity->id)
                        ->where('student_id', $student->id)
                        ->first();
                @endphp

                <tr>
                    <td>
                        {{ $student->name }}
                        <input type="hidden" 
                               name="scores[{{ $index }}][student_id]" 
                               value="{{ $student->id }}">
                    </td>

                    <td>
                        <input type="number"
                               name="scores[{{ $index }}][score]"
                               value="{{ $score->score ?? '' }}"
                               step="0.1"
                               min="0"
                               max="5"
                               class="form-control">
                    </td>
                </tr>

            @endforeach

        </tbody>
    </table>

    <button class="btn btn-success btn-sm">💾 Guardar Notas</button>
</form>