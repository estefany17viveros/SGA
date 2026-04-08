@extends('layouts.app')
@section('title', 'Profesores')
@push('styles')
    @vite('resources/css/admin/teachers/index.css')
@endpush
@section('content')

<h2>📋 Profesores</h2>

<a href="{{ route('admin.teachers.create') }}">Crear</a>

{{-- ✅ MENSAJE --}}
@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="8">

    <thead>
        <tr>
            <th>#</th>
            <th>Foto</th>
            <th>Nombre</th>
            <th>Documento</th>
            <th>Edad</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>

        @forelse($teachers as $teacher)
        <tr>

            {{-- NUMERO --}}
            <td>{{ $loop->iteration }}</td>

            {{-- FOTO --}}
            <td>
                @if($teacher->photo)
                    <img src="{{ asset('storage/'.$teacher->photo) }}" width="50">
                @else
                    Sin foto
                @endif
            </td>

            {{-- NOMBRE --}}
            <td>{{ $teacher->full_name }}</td>

            {{-- DOCUMENTO --}}
            <td>{{ $teacher->document_number }}</td>

            {{-- EDAD --}}
            <td>{{ $teacher->age }} años</td>

            {{-- TELEFONO --}}
            <td>{{ $teacher->phone ?? 'N/A' }}</td>

            {{-- CORREO --}}
            <td>{{ $teacher->user->email ?? 'Sin correo' }}</td>

            {{-- ESTADO --}}
            <td>
                @if($teacher->is_active)
                    <span style="color: green">Activo</span>
                @else
                    <span style="color: red">Inactivo</span>
                @endif
            </td>

            {{-- ACCIONES --}}
            <td>

                <a href="{{ route('admin.teachers.show', $teacher->id) }}">
                    👁 Ver
                </a>

                <a href="{{ route('admin.teachers.edit',$teacher->id) }}">
                    ✏️ Editar
                </a>
                <a href="{{ route('admin.teacher-subjects.index', $teacher->id) }}">
    📚 Asignación Académica
</a>

                <form method="POST" action="{{ route('admin.teachers.destroy',$teacher->id) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('¿Eliminar profesor?')">
                        🗑 Eliminar
                    </button>
                </form>

            </td>

        </tr>

        @empty
        <tr>
            <td colspan="9">No hay profesores registrados</td>
        </tr>
        @endforelse

    </tbody>

</table>

{{-- PAGINACIÓN --}}
{{ $teachers->links() }}

@endsection