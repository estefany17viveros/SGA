@extends('layouts.app')
@push('styles')
@vite('resources/css/admin/academic_years/show.css')
@endpush
@section('content')
<div class="container">

    <h2>Detalle Año Académico</h2>

    <ul class="list-group">
        <li class="list-group-item"><strong>Año:</strong> {{ $academicYear->year }}</li>
        <li class="list-group-item"><strong>Calendario:</strong> {{ $academicYear->calendar }}</li>
        <li class="list-group-item">
<strong>Inicio:</strong>
{{ \Carbon\Carbon::parse($academicYear->start_date)->format('d/m/Y') }}
</li>

<li class="list-group-item">
<strong>Fin:</strong>
{{ \Carbon\Carbon::parse($academicYear->end_date)->format('d/m/Y') }}
</li>
        <li class="list-group-item"><strong>Períodos:</strong> {{ $academicYear->periods }}</li>
        <li class="list-group-item"><strong>Estado:</strong> {{ $academicYear->status }}</li>
    </ul>

    <a href="{{ route('admin.academic_years.index') }}"
       class="btn btn-secondary mt-3">
        Volver
    </a>

</div>
@endsection