@extends('layouts.app')

@section('title', 'Editar Estudiante')

@push('styles')
@vite('resources/css/admin/students/edit.css')    
@endpush

@section('content')

<div class="edit-student-container">

    <div class="form-header">
        <h3>✏️ Editar Estudiante</h3>
        <p class="form-subtitle">Actualiza la información del estudiante</p>
    </div>

    @if ($errors->any())
        <div class="alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">

        <form action="{{ route('admin.students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-grid">

                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="first_name"
                        value="{{ $student->first_name }}"
                        class="form-input">
                </div>

                <div class="form-group">
                    <label>Apellido</label>
                    <input type="text" name="last_name"
                        value="{{ $student->last_name }}"
                        class="form-input">
                </div>

                <div class="form-group">
                    <label>Género</label>
                    <select name="gender" class="form-input">
                        <option value="masculino" {{ $student->gender == 'masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="femenino" {{ $student->gender == 'femenino' ? 'selected' : '' }}>Femenino</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Fecha de Nacimiento</label>
                    <input type="date"
                        name="birth_date"
                        value="{{ optional($student->birth_date)->format('Y-m-d') }}"
                        class="form-input">
                </div>

                <div class="form-group">
                    <label>Documento</label>
                    <input type="text"
                        name="identification_number"
                        value="{{ $student->identification_number }}"
                        class="form-input">
                </div>

                <div class="form-group">
                    <label>EPS</label>
                    <input type="text"
                        name="eps"
                        value="{{ $student->eps }}"
                        class="form-input">
                </div>

                {{-- 🔥 OBSERVACIÓN GENERAL --}}
                <div class="form-group full-width">
                    <label>Observación del estudiante</label>
                    <textarea name="observations" class="form-input" rows="4">
{{ $student->observations }}
                    </textarea>
                </div>

                {{-- 🔥 CERTIFICADO PDF --}}
                <div class="form-group full-width">
                    <label>Certificado (PDF)</label>

                    @if($student->certificate_file)
                        <a href="{{ asset('storage/'.$student->certificate_file) }}" target="_blank">
                            📄 Ver archivo actual
                        </a>
                    @endif

                    <input type="file" name="certificate_file" class="form-input">
                </div>

                {{-- FOTO --}}
                <div class="form-group full-width">
                    <label>Foto</label>

                    @if($student->photo)
                        <img src="{{ asset('storage/'.$student->photo) }}" width="80">
                    @endif

                    <input type="file" name="photo" class="form-input">
                </div>

            </div>

            <div class="form-actions">
                <a href="{{ route('admin.students.index') }}" class="btn-cancel">
                    Cancelar
                </a>

                <button type="submit" class="btn-submit">
                    💾 Actualizar
                </button>
            </div>

        </form>

    </div>

</div>

@endsection