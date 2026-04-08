@extends('layouts.app')
@push('styles')
@vite('resources/css/admin/periods/show.css')
@endpush
@section('content')

<h2>Detalle del Periodo</h2>

<p><strong>#:</strong> {{ $period->number }}</p>
<p><strong>Nombre:</strong> {{ $period->name }}</p>
<p><strong>Inicio:</strong> {{ $period->start_date }}</p>
<p><strong>Fin:</strong> {{ $period->end_date }}</p>
<p><strong>Porcentaje:</strong> {{ number_format($period->percentage,2) }}%</p>
<p><strong>Estado:</strong> {{ $period->status }}</p>

<br>

<a href="{{ route('admin.periods.index',$period->academic_year_id) }}">
Volver
</a>

@endsection