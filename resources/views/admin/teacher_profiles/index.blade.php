@extends('layouts.app')

@section('title', 'Lista de Profesores')

@push('styles')
    @vite('resources/css/teachers/index.css')


@section('content')

<div class="teachers-list-container">

    {{-- Header --}}
    <div class="list-header">
        <h1>👨‍🏫 Lista de Profesores</h1>

        <a href="{{ route('admin.teacher-profiles.create') }}" class="btn-new">
            ➕ Nuevo Profesor
        </a>
    </div>

    {{-- Mensaje éxito --}}
    @if(session('success'))
        <div class="table-card">
            <div class="success-message">
                <span class="message-icon">✓</span>
                {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- Tabla --}}
    <div class="table-card">
        <div class="table-wrapper">

            <table class="teachers-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre Completo</th>
                        <th>Correo</th>
                        <th class="center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($teachers as $teacher)
                        <tr>
                            <td class="td-num">
                                {{ $loop->iteration }}
                            </td>

                            <td class="td-name">
                                {{ $teacher->first_name }}
                                {{ $teacher->last_name }}
                            </td>

                            <td class="td-email">
                                {{ $teacher->user->email ?? 'Sin correo' }}
                            </td>

                            <td class="center">
                                <div class="actions-cell">

                                    {{-- VER --}}
                                    <a href="{{ route('admin.teacher-profiles.show', $teacher->id) }}"
                                       class="btn-view">
                                        👁 Ver
                                    </a>

                                    {{-- EDITAR --}}
                                    <a href="{{ route('admin.teacher-profiles.edit', $teacher->id) }}"
                                       class="btn-edit">
                                        ✏️ Editar
                                    </a>

                                    {{-- ELIMINAR --}}
                                    <form action="{{ route('admin.teacher-profiles.destroy', $teacher->id) }}"
                                          method="POST"
                                          class="delete-form"
                                          onsubmit="return confirm('¿Seguro que deseas eliminar este profesor?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn-delete">
                                            🗑 Eliminar
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <span class="empty-icon">📭</span>
                                    <p>No hay profesores registrados.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection