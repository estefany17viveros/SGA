@extends('layouts.app')

@push('styles')
@vite('resources/css/admin/loginlogs/index.css')
@endpush

@section('content')
<div class="container">

    <h2 class="mb-4">Registro de Ingresos al Sistema</h2>

    {{-- 🔍 FILTRO POR FECHAS --}}
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.login-logs.index') }}" class="row g-3 align-items-end">

                <div class="col-md-3">
                    <label class="form-label">Desde</label>
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Hasta</label>
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                </div>

                <div class="col-md-6">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            🔍 Filtrar
                        </button>
                        <a href="{{ route('admin.login-logs.index') }}" class="btn btn-secondary">
                            ♻ Limpiar
                        </a>
                    </div>
                </div>

            </form>
        </div>
    </div>

    {{-- 📋 TABLA --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-hover table-striped align-middle text-center mb-0">

                <thead class="table-dark">
                    <tr>
                        <th>👤 Nombre</th>
                        <th>Rol</th>
                        <th>🟢 Ingreso</th>
                        <th>🔴 Salida</th>
                        <th>Estado</th>
                        <th>🌐 IP</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($logs as $log)
                    <tr>

                        {{-- NOMBRE --}}
                        <td>
                            <strong>{{ ucfirst($log->name) }}</strong>
                        </td>

                        {{-- ROL --}}
                        <td>
                            @if($log->role == 'admin')
                                <span class="badge bg-success px-3 py-2">Administrador</span>
                            @elseif($log->role == 'teacher')
                                <span class="badge bg-primary px-3 py-2">Profesor</span>
                            @else
                                <span class="badge bg-secondary px-3 py-2">{{ $log->role }}</span>
                            @endif
                        </td>

                        {{-- INGRESO --}}
                        <td>
                            @if($log->login_at)
                                <span class="text-success fw-semibold">
                                    {{ \Carbon\Carbon::parse($log->login_at)->format('d/m/Y') }}
                                </span><br>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($log->login_at)->format('h:i A') }}
                                </small>
                            @else
                                —
                            @endif
                        </td>

                        {{-- SALIDA --}}
                        <td>
                            @if($log->logout_at)
                                <span class="text-danger fw-semibold">
                                    {{ \Carbon\Carbon::parse($log->logout_at)->format('d/m/Y') }}
                                </span><br>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($log->logout_at)->format('h:i A') }}
                                </small>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        {{-- ESTADO --}}
                        <td>
                            @if($log->logout_at)
                                <span class="badge bg-secondary px-3 py-2">
                                    🔴 Finalizado
                                </span>
                            @else
                                <span class="badge bg-warning text-dark px-3 py-2">
                                    🟢 En línea
                                </span>
                            @endif
                        </td>

                        {{-- IP --}}
                        <td>
                            <small class="text-muted">{{ $log->ip_address }}</small>
                        </td>

                    </tr>
                @empty

                    <tr>
                        <td colspan="6">
                            <p class="text-muted my-3">No hay registros aún.</p>
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>
    </div>

    {{-- 📄 PAGINACIÓN --}}
    <div class="mt-3">
        {{ $logs->links() }}
    </div>

</div>
@endsection