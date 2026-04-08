
@extends('layouts.app')

@section('title','Registrar Acudiente')
@push('styles')
@vite('resources/css/admin/guardians/create.css')
@endpush
@section('content')

<div class="container">

<h3>👨‍👩‍👦 Registrar Acudiente del Estudiante</h3>

<div class="card">
<div class="card-body">

@if ($errors->any())
<div class="alert alert-danger">
<strong>Corrige los siguientes errores:</strong>
<ul class="mb-0 mt-2">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif


<form action="{{ route('admin.guardians.store') }}" method="POST">

@csrf

<!-- estudiante vinculado automáticamente -->
<input type="hidden" name="student_id" value="{{ $student->id }}">


<div class="mb-3">
<label class="form-label"><strong>Estudiante</strong></label>
<input type="text" class="form-control"
value="{{ $student->full_name }}" readonly>
</div>


<div class="row">

<div class="col-md-6 mb-3">
<label class="form-label">Nombre del Acudiente</label>
<input type="text" name="first_name"
class="form-control"
value="{{ old('first_name') }}"
required>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Apellido del Acudiente</label>
<input type="text" name="last_name"
class="form-control"
value="{{ old('last_name') }}"
required>
</div>


<div class="col-md-6 mb-3">
<label class="form-label">Parentesco</label>
<select name="relationship" class="form-control" required>

<option value="">Seleccione</option>

<option value="Padre" {{ old('relationship')=='Padre'?'selected':'' }}>
Padre
</option>

<option value="Madre" {{ old('relationship')=='Madre'?'selected':'' }}>
Madre
</option>

<option value="Tutor" {{ old('relationship')=='Tutor'?'selected':'' }}>
Tutor
</option>

<option value="Otro" {{ old('relationship')=='Otro'?'selected':'' }}>
Otro
</option>

</select>
</div>


<div class="col-md-6 mb-3">
<label class="form-label">Número de Identificación</label>
<input type="text"
name="identification_number"
class="form-control"
value="{{ old('identification_number') }}">
</div>


<div class="col-md-6 mb-3">
<label class="form-label">Teléfono</label>
<input type="text"
name="phone"
class="form-control"
value="{{ old('phone') }}"
required>
</div>


<div class="col-md-6 mb-3">
<label class="form-label">Correo Electrónico</label>
<input type="email"
name="email"
class="form-control"
value="{{ old('email') }}">
</div>


<div class="col-md-6 mb-3">
<label class="form-label">Ocupación</label>
<input type="text"
name="occupation"
class="form-control"
value="{{ old('occupation') }}">
</div>


<div class="col-md-12 mb-3">
<label class="form-label">Dirección</label>
<input type="text"
name="address"
class="form-control"
value="{{ old('address') }}">
</div>

</div>


<div class="mt-3">

<button class="btn btn-success">
💾 Guardar Acudiente
</button>

<a href="{{ route('admin.students.show',$student->id) }}"
class="btn btn-secondary">
Cancelar
</a>

</div>

</form>

</div>
</div>

</div>

@endsection
