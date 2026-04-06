@extends('layouts.app')

@push('styles')
@vite('resources/css/periods/edit.css')
@endpush
@section('content')

<h2>Editar Periodo</h2>

@if(session('error'))
<p style="color:red">{{ session('error') }}</p>
@endif

<form method="POST" action="{{ route('admin.periods.update',$period->id) }}">
@csrf
@method('PUT')

<label>Nombre</label><br>
<input type="text" name="name" value="{{ $period->name }}"><br><br>

<label>Inicio</label><br>
<input type="date" name="start_date" value="{{ $period->start_date }}"><br><br>

<label>Fin</label><br>
<input type="date" name="end_date" value="{{ $period->end_date }}"><br><br>

<label>Porcentaje</label><br>
<input type="number" step="0.01" name="percentage" value="{{ $period->percentage }}"><br><br>

<button>Guardar</button>

</form>

<br>
<a href="{{ route('admin.periods.index',$period->academic_year_id) }}">Volver</a>

@endsection