@extends('layouts.app')

@section('title','Acudientes')

@push('styles')
@vite('resources/css/guardians/index.css')
@endpush

@section('content')

<div class="container">

<div class="d-flex justify-content-between mb-3">
<h3>👨‍👩‍👦 Acudientes</h3>
</div>

@if(session('success'))

<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

<!-- BUSCADOR -->

<div class="card mb-3">
<div class="card-body">

<form method="GET" action="{{ route('admin.guardians.index') }}">

<div class="row">

<div class="col-md-6">

<input type="text"
name="apellido"
value="{{ request('apellido') }}"
class="form-control"
placeholder="Buscar por apellido del estudiante">

</div>

<div class="col-md-3">

<button class="btn btn-primary">
🔍 Buscar
</button>

<a href="{{ route('admin.guardians.index') }}"
class="btn btn-secondary">
Limpiar </a>

</div>

</div>

</form>

</div>
</div>

<div class="card">
<div class="card-body">

<table class="table table-striped">

<thead>
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Apellido</th>
<th>Parentesco</th>
<th>Teléfono</th>
<th>Estudiante</th>
<th>Acciones</th>
</tr>
</thead>

<tbody>

@forelse($guardians as $guardian)

<tr>

<td>{{ $guardian->id }}</td>

<td>{{ $guardian->first_name }}</td>

<td>{{ $guardian->last_name }}</td>

<td>{{ $guardian->relationship }}</td>

<td>{{ $guardian->phone }}</td>

<td>{{ $guardian->student->full_name ?? '' }}</td>

<td>

<a href="{{ route('admin.guardians.show',$guardian->id) }}"
class="btn btn-info btn-sm">Ver</a>

<a href="{{ route('admin.guardians.edit',$guardian->id) }}"
class="btn btn-warning btn-sm">Editar</a>

<form action="{{ route('admin.guardians.destroy',$guardian->id) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm"
onclick="return confirm('Eliminar acudiente?')">
Eliminar </button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="6" class="text-center">
No se encontraron resultados
</td>
</tr>

@endforelse

</tbody>

</table>

{{ $guardians->links() }}

</div>
</div>

</div>

@endsection
