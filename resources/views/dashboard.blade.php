@push('styles')
    @vite('resources/css/dashboard.css')
@endpush

<x-app-layout>

    {{-- ─── Header ─────────────────────────────────────────── --}}
    

    <div class="dashboard-wrapper">

        {{-- ─── Banner ──────────────────────────────────────── --}}
        <div class="dashboard-banner">
            <div class="banner-content">
                <h2>Bienvenida, {{ Auth::user()->name }} 👋</h2>
                <p> Control total del sistema</p>
            </div>
        </div>

        {{-- ─── Tarjetas de estadísticas ────────────────────── --}}
        <div class="stats-grid">

            <div class="stat-card stat-role">
                <span class="stat-icon">🎓</span>
                <p class="stat-label">Rol</p>
                <h3 class="stat-value">{{ ucfirst(Auth::user()->role) }}</h3>
            </div>

            <div class="stat-card stat-total">
                <span class="stat-icon">👥</span>
                <p class="stat-label">Total Estudiantes</p>
                <h3 class="stat-value">{{ $totalStudents ?? 0 }}</h3>
            </div>

            <div class="stat-card stat-adults">
                <span class="stat-icon">🔞</span>
                <p class="stat-label">Mayores de edad</p>
                <h3 class="stat-value">{{ $adultStudentsCount ?? 0 }}</h3>
            </div>

            <div class="stat-card stat-minors">
                <span class="stat-icon">🧒</span>
                <p class="stat-label">Menores de edad</p>
                <h3 class="stat-value">{{ ($totalStudents ?? 0) - ($adultStudentsCount ?? 0) }}</h3>
            </div>

            <div class="stat-card stat-status">
                <span class="stat-icon">⚡</span>
                <p class="stat-label">Estado Sistema</p>
                <h3 class="stat-value">
                    <span class="stat-dot"></span>Activo
                </h3>
            </div>

        </div>

        {{-- ─── Tabla principal ─────────────────────────────── --}}
        <div class="table-card">

            <div class="table-card-header">
                <h2>👨‍🎓 Estudiantes mayores de edad (18+)</h2>
                @if(isset($adultStudents))
                    <span class="table-count-badge">{{ $adultStudentsCount ?? 0 }} registros</span>
                @endif
            </div>

            @if(isset($adultStudents) && $adultStudents->count())
                <div class="table-scroll">
                    <table class="students-table">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Edad</th>
                                <th>Estado</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($adultStudents as $index => $student)
                                <tr>
                                    <td class="col-num">{{ $index + 1 }}</td>

                                    <td class="col-name">
                                        {{ $student->first_name }} {{ $student->last_name }}
                                    </td>

                                    <td class="col-age">
                                        {{ \Carbon\Carbon::parse($student->birth_date)->age }} años
                                    </td>

                                    

                                    <td>
                                        <span class="badge-active">
                                            <span class="dot"></span>
                                            Activo
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            @else
                <div class="empty-state">
                    <span class="empty-icon">🎓</span>
                    <p>No hay estudiantes mayores de edad registrados.</p>
                </div>
            @endif

        </div>

        {{-- ─── Resumen y recomendación ─────────────────────── --}}
        <div class="summary-grid">

            <div class="summary-card">
                <h3>Resumen</h3>
                <p>
                    Este panel permite visualizar rápidamente el estado de los estudiantes,
                    identificar mayores de edad y tener control general del sistema académico.
                </p>
            </div>

            <div class="summary-card">
                <h3>Recomendación</h3>
                <p>
                    Se recomienda hacer seguimiento especial a estudiantes mayores de edad
                    para procesos administrativos, documentación o validaciones legales.
                </p>
            </div>

        </div>

    </div>

</x-app-layout>