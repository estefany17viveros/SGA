
@extends('layouts.app')

@section('title','Editar Acudiente')
@push('styles')
@vite('resources/css/guardians/edit.css')
@endpush
@section('content')

<div class="container">

<h3>Editar Acudiente</h3>

<div class="card">
<div class="card-body">

<form action="{{ route('admin.guardians.update',$guardian->id) }}" method="POST">

@csrf
@method('PUT')

<div class="row">

<div class="col-md-6">
<label>Estudiante</label>

<select name="student_id" class="form-control">

@foreach($students as $student)

<option value="{{ $student->id }}"
{{ $guardian->student_id == $student->id ? 'selected' : '' }}>

{{ $student->full_name }}

</option>

@endforeach

</select>

</div>

<div class="col-md-6">
<label>Nombre Completo</label>

<input type="text"
name="full_name"
class="form-control"
value="{{ $guardian->full_name }}">
</div>

<div class="col-md-6">
<label>Parentesco</label>

<input type="text"
name="relationship"
class="form-control"
value="{{ $guardian->relationship }}">
</div>

<div class="col-md-6">
<label>Identificación</label>

<input type="text"
name="identification_number"
class="form-control"
value="{{ $guardian->identification_number }}">
</div>

<div class="col-md-6">
<label>Teléfono</label>

<input type="text"
name="phone"
class="form-control"
value="{{ $guardian->phone }}">
</div>

<div class="col-md-6">
<label>Email</label>

<input type="email"
name="email"
class="form-control"
value="{{ $guardian->email }}">
</div>

<div class="col-md-6">
<label>Ocupación</label>

<input type="text"
name="occupation"
class="form-control"
value="{{ $guardian->occupation }}">
</div>

<div class="col-md-12">
<label>Dirección</label>

<input type="text"
name="address"
class="form-control"
value="{{ $guardian->address }}">
</div>

</div>

<br>

<button class="btn btn-primary">
Actualizar
</button>

</form>

</div>
</div>

</div>

@endsection
