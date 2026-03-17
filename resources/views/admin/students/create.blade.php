
@extends('layouts.app')

@push('styles')
@vite('resources/css/students/create.css')

@endpush

@section('content')

<div class="container">

<h3 class="mb-4">Crear Estudiante</h3>

@if ($errors->any())
<div class="alert alert-danger">

<strong>Por favor corrige los siguientes errores:</strong>

<ul class="mb-0 mt-2">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>

</div>
@endif


<form action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data" novalidate>
@csrf


{{-- PASO 1 --}}
<div class="card step active" id="step1">

<div class="card-header bg-primary text-white">
Paso 1 - Información del estudiante
</div>

<div class="card-body">

<div class="row">

<div class="col-md-4">
<label>Foto</label>
<input type="file" name="photo" class="form-control">
</div>

<div class="col-md-4">
<label>Nombre</label>
<input type="text" name="first_name" value="{{ old('first_name') }}"
class="form-control @error('first_name') is-invalid @enderror">

@error('first_name')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>

<div class="col-md-4">
<label>Apellido</label>
<input type="text" name="last_name" value="{{ old('last_name') }}"
class="form-control @error('last_name') is-invalid @enderror">

@error('last_name')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>


<div class="col-md-4 mt-3">

<label>Genero</label>

<select name="gender"
class="form-control @error('gender') is-invalid @enderror">

<option value="">Seleccione</option>

<option value="masculino" {{ old('gender')=='masculino'?'selected':'' }}>Masculino</option>
<option value="femenino" {{ old('gender')=='femenino'?'selected':'' }}>Femenino</option>

</select>

@error('gender')
<div class="invalid-feedback">{{ $message }}</div>
@enderror

</div>


<div class="col-md-4 mt-3">

<label>Fecha nacimiento</label>

<input type="date" name="birth_date"
value="{{ old('birth_date') }}"
class="form-control @error('birth_date') is-invalid @enderror">

@error('birth_date')
<div class="invalid-feedback">{{ $message }}</div>
@enderror

</div>


<div class="col-md-4 mt-3">

<label>Tipo documento</label>

<select name="identification_type"
class="form-control @error('identification_type') is-invalid @enderror">

<option value="">Seleccione</option>

<option value="registro_civil" {{ old('identification_type')=='registro_civil'?'selected':'' }}>Registro Civil</option>
<option value="tarjeta_identidad" {{ old('identification_type')=='tarjeta_identidad'?'selected':'' }}>Tarjeta Identidad</option>
<option value="cedula_ciudadania" {{ old('identification_type')=='cedula_ciudadania'?'selected':'' }}>Cédula Ciudadanía</option>
<option value="cedula_extranjeria" {{ old('identification_type')=='cedula_extranjeria'?'selected':'' }}>Cédula Extranjería</option>
<option value="pasaporte" {{ old('identification_type')=='pasaporte'?'selected':'' }}>Pasaporte</option>

</select>

@error('identification_type')
<div class="invalid-feedback">{{ $message }}</div>
@enderror

</div>


<div class="col-md-4 mt-3">

<label>Número documento</label>

<input type="text" name="identification_number"
value="{{ old('identification_number') }}"
class="form-control @error('identification_number') is-invalid @enderror">

@error('identification_number')
<div class="invalid-feedback">{{ $message }}</div>
@enderror

</div>


<div class="col-md-4 mt-3">

<label>Fecha expedición</label>

<input type="date" name="expedition_date"
value="{{ old('expedition_date') }}"
class="form-control @error('expedition_date') is-invalid @enderror">

@error('expedition_date')
<div class="invalid-feedback">{{ $message }}</div>
@enderror

</div>


<div class="col-md-4 mt-3">

<label>Departamento expedición</label>

<input type="text" name="expedition_department"
value="{{ old('expedition_department') }}"
class="form-control @error('expedition_department') is-invalid @enderror">

@error('expedition_department')
<div class="invalid-feedback">{{ $message }}</div>
@enderror

</div>


<div class="col-md-6 mt-3">

<label>Municipio expedición</label>

<input type="text" name="expedition_municipality"
value="{{ old('expedition_municipality') }}"
class="form-control @error('expedition_municipality') is-invalid @enderror">

@error('expedition_municipality')
<div class="invalid-feedback">{{ $message }}</div>
@enderror

</div>


<div class="col-md-6 mt-3">

<label>Dirección</label>

<input type="text" name="address"
value="{{ old('address') }}"
class="form-control @error('address') is-invalid @enderror">

@error('address')
<div class="invalid-feedback">{{ $message }}</div>
@enderror

</div>

</div>

<div class="text-end mt-4">
<button type="button" class="btn btn-primary" onclick="nextStep()">Siguiente</button>
</div>

</div>
</div>



{{-- PASO 2 --}}
<div class="card step" id="step2">

<div class="card-header bg-success text-white">
Paso 2 - Información de salud
</div>

<div class="card-body">

<div class="row">

<div class="col-md-6">

<label>EPS</label>

<input type="text" name="eps"
value="{{ old('eps') }}"
class="form-control @error('eps') is-invalid @enderror">

@error('eps')
<div class="invalid-feedback">{{ $message }}</div>
@enderror

</div>


<div class="col-md-6">

<label>Tipo de sangre</label>

<select name="blood_type"
class="form-control @error('blood_type') is-invalid @enderror">

<option value="">Seleccione</option>

<option {{ old('blood_type')=='A+'?'selected':'' }}>A+</option>
<option {{ old('blood_type')=='A-'?'selected':'' }}>A-</option>
<option {{ old('blood_type')=='B+'?'selected':'' }}>B+</option>
<option {{ old('blood_type')=='B-'?'selected':'' }}>B-</option>
<option {{ old('blood_type')=='AB+'?'selected':'' }}>AB+</option>
<option {{ old('blood_type')=='AB-'?'selected':'' }}>AB-</option>
<option {{ old('blood_type')=='O+'?'selected':'' }}>O+</option>
<option {{ old('blood_type')=='O-'?'selected':'' }}>O-</option>

</select>

@error('blood_type')
<div class="invalid-feedback">{{ $message }}</div>
@enderror

</div>


<div class="col-md-12 mt-3">

<label>Condiciones médicas</label>

<textarea name="medical_conditions"
class="form-control">{{ old('medical_conditions') }}</textarea>

</div>

</div>

<div class="d-flex justify-content-between mt-4">

<button type="button" class="btn btn-secondary" onclick="prevStep()">Anterior</button>
<button type="button" class="btn btn-primary" onclick="nextStep()">Siguiente</button>

</div>

</div>
</div>



{{-- PASO 3 --}}
<div class="card step" id="step3">

<div class="card-header bg-dark text-white">
Paso 3 - Información adicional
</div>

<div class="card-body">

<div class="row">

<div class="col-md-6">

<label>PDF certificado</label>

<input type="file" name="certificate_file"
class="form-control @error('certificate_file') is-invalid @enderror">

@error('certificate_file')
<div class="invalid-feedback">{{ $message }}</div>
@enderror

</div>


<div class="col-md-12 mt-3">

<label>Observaciones</label>

<textarea name="observations"
class="form-control">{{ old('observations') }}</textarea>

</div>

</div>

<div class="d-flex justify-content-between mt-4">

<button type="button" class="btn btn-secondary" onclick="prevStep()">Anterior</button>

<button type="submit" class="btn btn-success">
Guardar Estudiante
</button>

</div>

</div>
</div>

</form>

</div>


<script>

let currentStep = 1;
const totalSteps = 3;

function showStep(step){

document.querySelectorAll('.step').forEach((card)=>{
card.classList.remove('active');
});

document.getElementById('step'+step).classList.add('active');

}

function nextStep(){

if(currentStep < totalSteps){
currentStep++;
showStep(currentStep);
}

}

function prevStep(){

if(currentStep > 1){
currentStep--;
showStep(currentStep);
}

}


@if ($errors->any())

let stepError = 1;

@if ($errors->has('eps') || $errors->has('blood_type') )
stepError = 2;
@endif

@if ($errors->has('certificate_file'))
stepError = 3;
@endif

currentStep = stepError;
showStep(currentStep);

@endif

</script>

@endsection
