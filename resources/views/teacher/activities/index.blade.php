@extends('layouts.app')

@section('title', 'Sistema Académico')

@section('content')

<div class="container">
    <h2>📊 Sistema Académico</h2>

    {{-- MENSAJES --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- 🔽 SELECT GRADO --}}
    <form method="GET">
        <div class="mb-3">
            <label><strong>Seleccionar grado</strong></label>
            <select name="grade_id" class="form-control" onchange="this.form.submit()">
                <option value="">Seleccione...</option>
                @foreach($grades as $grade)
                    <option value="{{ $grade->id }}" 
                        {{ request('grade_id') == $grade->id ? 'selected' : '' }}>
                        {{ $grade->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    {{-- 🔥 ACTIVIDADES --}}
    @if($activities->count())

        @foreach(['saber','hacer','ser'] as $type)

            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    {{ strtoupper($type) }}
                </div>

                <div class="card-body">

                    @forelse($activities[$type] ?? [] as $activity)

                        <button class="btn btn-info mb-2"
                                onclick="toggle({{ $activity->id }})">
                            {{ $activity->description }} ({{ $activity->percentage }}%)
                        </button>

                        {{-- 🔽 ESTUDIANTES --}}
                        <div id="activity-{{ $activity->id }}" style="display:none">
                            @include('teacher.activities.partials.students', [
                                'activity' => $activity,
                                'students' => $students
                            ])
                        </div>

                    @empty
                        <p>No hay actividades</p>
                    @endforelse

                </div>
            </div>

        @endforeach

    @endif

</div>

<script>
function toggle(id){
    let el = document.getElementById('activity-' + id);
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
</script>

@endsection