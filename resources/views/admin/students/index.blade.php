@extends('layouts.app')

@push('styles')
@vite('resources/css/students/index.css')
@endpush

@section('title', 'Estudiantes')

@section('content')

<div class="students-container">
<div class="page-header">
    <div class="header-content">
        <h3>👨‍🎓 Estudiantes</h3>
        <p class="subtitle">Gestiona todos los estudiantes del sistema</p>
    </div>

    <a href="{{ route('admin.students.create') }}" class="btn-create">
        <span class="icon">➕</span>
        Nuevo Estudiante
    </a>
</div>


@if(session('success'))

<div class="success-message">
<span class="message-icon">✓</span>
{{ session('success') }}
</div>
@endif

<!-- BUSCADOR -->

<div class="search-container">

<form method="GET" action="{{ route('admin.students.index') }}">

<div class="search-box">

<input
type="text"
name="search"
value="{{ request('search') }}"
placeholder="Buscar por nombre, apellido o documento"
class="search-input">

<button class="btn-search">
🔍 Buscar
</button>

<a href="{{ route('admin.students.index') }}" class="btn-reset">
Limpiar
</a>

</div>

</form>

</div>

<div class="table-container">
<table class="students-table">

<thead>
<tr>
<th>Foto</th>
<th>Nombre Completo</th>
<th>Documento</th>
<th>Edad</th>
<th>EPS</th>
<th>Acciones</th>
</tr>
</thead>

<tbody>

@forelse($students as $student)

<tr>

<td class="photo-cell">
@if($student->photo)
<img src="{{ asset('storage/'.$student->photo) }}" class="student-photo">
@else
<div class="photo-placeholder">
<span class="placeholder-icon">👤</span>
</div>
@endif
</td>

<td class="name-cell">
<span class="student-name">{{ $student->full_name }}</span>
</td>

<td>
{{ $student->identification_number }}
</td>

<td>
<span class="age-badge">{{ $student->age }} años</span>
</td>

<td>
{{ $student->eps }}
</td>

<td class="actions-cell">

<a href="{{ route('admin.students.show', $student->id) }}" class="btn-action btn-view">
👁️ Ver
</a>

<a href="{{ route('admin.students.edit', $student->id) }}" class="btn-action btn-edit">
✏️ Editar
</a>

<form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="delete-form">
@csrf
@method('DELETE')

<button
type="submit"
class="btn-action btn-delete"
onclick="return confirm('¿Está seguro de eliminar a {{ $student->full_name }}?')">
🗑️ Eliminar </button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="6" class="empty-state">
<div class="empty-content">
<span class="empty-icon">📚</span>
<p>No se encontraron estudiantes</p>

<a href="{{ route('admin.students.index') }}" class="btn-create-first">
Mostrar todos
</a>

</div>
</td>
</tr>

@endforelse

</tbody>

</table>
</div>

<div class="pagination-container">
{{ $students->appends(request()->query())->links() }}
</div>

</div>

@endsection
