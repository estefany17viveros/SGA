@extends('layouts.app')

@push('styles')
@vite('resources/css/admin/boletin/grade.css')
@endpush

@section('content')

<div class="container">

    <h2>📚 Estudiantes del grado</h2>

    {{-- 🔥 SELECTOR DE PERIODO --}}
    <div class="mb-3">

        <label><strong>Seleccionar periodo:</strong></label>

        <select id="periodSelect" class="form-control">
            @foreach($periods as $period)
                <option value="{{ $period->id }}">
                    {{ $period->name }}
                </option>
            @endforeach
        </select>

    </div>

    {{-- 🔥 BOTÓN PDF MASIVO --}}
    <a id="btnPdfMasivo"
       href="#"
       class="btn btn-danger mb-3">
       📄 Descargar todos los boletines
    </a>

    {{-- 🔥 TABLA --}}
    <table class="table table-bordered">

        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Boletines</th>
            </tr>
        </thead>

        <tbody>

            @foreach($enrollments as $enrollment)

                <tr>
                    <td>
                        {{ $enrollment->student->first_name }}
                        {{ $enrollment->student->last_name }}
                    </td>

                    <td>

                        {{-- 🔥 BOTONES POR PERIODO --}}
                        @foreach($periods as $period)

                            <a href="{{ route('admin.boletin.show', [
                                $enrollment->student_id,
                                $period->id
                            ]) }}"
                               class="btn btn-info btn-sm">
                                Ver {{ $period->name }}
                            </a>

                            <a href="{{ route('admin.boletin.pdf', [
                                $enrollment->student_id,
                                $period->id
                            ]) }}"
                               class="btn btn-success btn-sm">
                                PDF
                            </a>

                        @endforeach

                    </td>
                </tr>

            @endforeach

        </tbody>

    </table>

</div>

{{-- 🔥 SCRIPT CLAVE --}}
<script>
    const select = document.getElementById('periodSelect');
    const btn = document.getElementById('btnPdfMasivo');

    function updateLink() {
        const periodId = select.value;
        btn.href = `/admin/boletin/grado/{{ $gradeId }}/pdf/${periodId}`;
    }

    // inicial
    updateLink();

    // cuando cambia
    select.addEventListener('change', updateLink);
</script>

@endsection