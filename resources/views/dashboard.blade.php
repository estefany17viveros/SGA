@push('styles')
    @vite('resources/css/dashboard.css')
@endpush

<x-app-layout>
<div class="dash-root">

    {{-- ══════════════════════════════════════════════════════
         HERO SECTION
    ══════════════════════════════════════════════════════ --}}
    <section class="hero">
        <div class="hero-orb hero-orb-1"></div>
        <div class="hero-orb hero-orb-2"></div>
        <div class="hero-orb hero-orb-3"></div>

        <div class="hero-content">
            <div class="hero-pills">
                <span class="pill pill-status">
                    <span class="pill-dot"></span>
                    Sistema Activo
                </span>
                <span class="pill pill-role">
                    🎓 {{ ucfirst(Auth::user()->role) }}
                </span>
            </div>

            <h1 class="hero-title">
                Hola, <em>{{ Auth::user()->name }}</em>
            </h1>
            <p class="hero-sub">Panel de control académico · Vista general del sistema</p>
        </div>

        {{-- Métricas hero --}}
        <div class="hero-stats">
            <div class="hstat">
                <span class="hstat-num">{{ $totalStudents ?? 0 }}</span>
                <span class="hstat-label">Total estudiantes</span>
            </div>
            <div class="hstat-sep"></div>
            <div class="hstat">
                <span class="hstat-num hstat-red">{{ $adultStudentsCount ?? 0 }}</span>
                <span class="hstat-label">Mayores de edad</span>
            </div>
            <div class="hstat-sep"></div>
            <div class="hstat">
                <span class="hstat-num hstat-amber">{{ ($totalStudents ?? 0) - ($adultStudentsCount ?? 0) }}</span>
                <span class="hstat-label">Menores de edad</span>
            </div>
            <div class="hstat-sep"></div>
            <div class="hstat">
                <span class="hstat-num hstat-teal">{{ count($upcomingStudents ?? []) }}</span>
                <span class="hstat-label">Próximos a los 18</span>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════
         CUERPO PRINCIPAL: 2 columnas
    ══════════════════════════════════════════════════════ --}}
    <div class="dash-body">

        {{-- ── Columna principal ──────────────────────────── --}}
        <div class="dash-main">

            {{-- ── Mayores de edad ──────────────────────────── --}}
            <div class="card">
                <div class="card-head">
                    <div class="card-head-left">
                        <span class="card-icon card-icon--red">18+</span>
                        <div>
                            <h2 class="card-title">Estudiantes mayores de edad</h2>
                            <p class="card-desc">Alumnos con 18 años cumplidos o más</p>
                        </div>
                    </div>
                    @if(isset($adultStudents))
                        <span class="badge badge--red">{{ $adultStudentsCount ?? 0 }} registros</span>
                    @endif
                </div>

                @if(isset($adultStudents) && $adultStudents->count())
                    <div class="table-scroll">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="col-num">#</th>
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
                                            <div class="avatar avatar--blue">
                                                {{ strtoupper(substr($student->first_name, 0, 1)) }}{{ strtoupper(substr($student->last_name, 0, 1)) }}
                                            </div>
                                            <span>{{ $student->first_name }} {{ $student->last_name }}</span>
                                        </td>
                                        <td>
                                            <span class="chip chip--red">
                                                {{ \Carbon\Carbon::parse($student->birth_date)->age }} años
                                            </span>
                                        </td>
                                        <td>
                                            <span class="chip chip--green">
                                                <span class="chip-dot"></span>
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

            {{-- ── Próximos a los 18 ─────────────────────── --}}
            <div class="card">
                <div class="card-head">
                    <div class="card-head-left">
                        <span class="card-icon card-icon--amber">⏳</span>
                        <div>
                            <h2 class="card-title">Próximos a cumplir 18 años</h2>
                            <p class="card-desc">Alertas de cambio de mayoría de edad</p>
                        </div>
                    </div>
                    <span class="badge badge--amber">{{ count($upcomingStudents ?? []) }} alertas</span>
                </div>

                @if(!empty($upcomingStudents))
                    <div class="table-scroll">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="col-num">#</th>
                                    <th>Nombre</th>
                                    <th>Días faltantes</th>
                                    <th>Alerta</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($upcomingStudents as $index => $student)
                                    <tr>
                                        <td class="col-num">{{ $index + 1 }}</td>
                                        <td class="col-name">
                                            <div class="avatar avatar--amber">
                                                {{ strtoupper(substr($student->first_name, 0, 1)) }}{{ strtoupper(substr($student->last_name, 0, 1)) }}
                                            </div>
                                            <span>{{ $student->first_name }} {{ $student->last_name }}</span>
                                        </td>
                                        <td>
                                            <span class="chip chip--amber">
                                                {{ $student->dias_faltantes }} días
                                            </span>
                                        </td>
                                        <td>
                                            <span class="alert-label">{{ $student->alerta }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <span class="empty-icon">⏳</span>
                        <p>No hay estudiantes próximos a cumplir 18 años.</p>
                    </div>
                @endif
            </div>

            {{-- ── Ranking por grado ─────────────────────── --}}
            <div class="card">
                <div class="card-head">
                    <div class="card-head-left">
                        <span class="card-icon card-icon--teal">🏆</span>
                        <div>
                            <h2 class="card-title">Ranking de estudiantes por grado</h2>
                            <p class="card-desc">Top 5 estudiantes según promedio académico</p>
                        </div>
                    </div>
                </div>

                @if(isset($rankingStudents) && count($rankingStudents))
                    @foreach($rankingStudents as $grade => $students)
                        <div class="ranking-block">
                            <h3 class="ranking-grade-title">🎓 {{ $grade }}</h3>
                            <div class="table-scroll">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Estudiante</th>
                                            <th>Promedio</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students->take(5) as $index => $student)
                                            <tr>
                                                <td class="col-medal">
                                                    @if($index === 0) 🥇
                                                    @elseif($index === 1) 🥈
                                                    @elseif($index === 2) 🥉
                                                    @else <span class="medal-num">{{ $index + 1 }}</span>
                                                    @endif
                                                </td>
                                                <td class="col-name">
                                                    <div class="avatar avatar--teal">
                                                        {{ strtoupper(substr($student->first_name, 0, 1)) }}{{ strtoupper(substr($student->last_name, 0, 1)) }}
                                                    </div>
                                                    <span>{{ $student->first_name }} {{ $student->last_name }}</span>
                                                </td>
                                                <td>
                                                    <span class="chip chip--blue">
                                                        {{ number_format($student->promedio, 2) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <span class="empty-icon">🏆</span>
                        <p>No hay datos de ranking disponibles.</p>
                    </div>
                @endif
            </div>

            {{-- ── Análisis Académico (Gráficas) ────────────── --}}
            <div class="card card--charts">
                <div class="card-head">
                    <div class="card-head-left">
                        <span class="card-icon card-icon--indigo">📊</span>
                        <div>
                            <h2 class="card-title">Análisis Académico</h2>
                            <p class="card-desc">Rendimiento por materias y grados</p>
                        </div>
                    </div>
                    <form method="GET" class="period-form">
                        <select name="period" onchange="this.form.submit()" class="period-select">
                            <option value="">Todos los periodos</option>
                            <option value="1" {{ ($period ?? '') == 1 ? 'selected' : '' }}>Periodo 1</option>
                            <option value="2" {{ ($period ?? '') == 2 ? 'selected' : '' }}>Periodo 2</option>
                            <option value="3" {{ ($period ?? '') == 3 ? 'selected' : '' }}>Periodo 3</option>
                        </select>
                    </form>
                </div>

                <div class="charts-grid">
                    <div class="chart-box">
                        <p class="chart-label chart-label--red">📉 Bajo rendimiento</p>
                        <canvas id="lowChart"></canvas>
                    </div>
                    <div class="chart-box">
                        <p class="chart-label chart-label--teal">📈 Mejor rendimiento</p>
                        <canvas id="topChart"></canvas>
                    </div>
                    <div class="chart-box chart-box--full">
                        <p class="chart-label chart-label--blue">🏫 Distribución por grado</p>
                        <canvas id="gradeChart"></canvas>
                    </div>
                </div>
            </div>

        </div>{{-- /dash-main --}}

        {{-- ── Sidebar derecha ─────────────────────────────── --}}
        <aside class="dash-side">

            {{-- Estado del sistema --}}
            <div class="side-card side-card--status">
                <div class="side-status-row">
                    <span class="status-dot-pulse"></span>
                    <span class="side-status-text">Sistema operativo</span>
                </div>
                <p class="side-status-sub">Todos los módulos funcionando con normalidad.</p>
            </div>

            {{-- Donut distribución --}}
            <div class="side-card">
                <h3 class="side-title">
                    <span class="side-icon">🍩</span>
                    Distribución por edad
                </h3>

                @php
                    $total  = $totalStudents ?? 1;
                    $adults = $adultStudentsCount ?? 0;
                    $minors = $total - $adults;
                    $pct    = $total > 0 ? round(($adults / $total) * 100) : 0;
                    $circ   = 282;
                    $dash   = round(($pct / 100) * $circ);
                @endphp

                <div class="donut-wrap">
                    <svg class="donut-svg" viewBox="0 0 100 100">
                        <circle class="donut-track" cx="50" cy="50" r="45"/>
                        <circle class="donut-arc"   cx="50" cy="50" r="45"
                                stroke-dasharray="{{ $dash }} {{ $circ - $dash }}"
                                stroke-dashoffset="70"/>
                        <text x="50" y="46" class="donut-pct">{{ $pct }}%</text>
                        <text x="50" y="58" class="donut-sub">adultos</text>
                    </svg>
                </div>

                <div class="donut-legend">
                    <span class="leg-item">
                        <span class="leg-dot leg-dot--red"></span>
                        Mayores: <strong>{{ $adults }}</strong>
                    </span>
                    <span class="leg-item">
                        <span class="leg-dot leg-dot--amber"></span>
                        Menores: <strong>{{ $minors }}</strong>
                    </span>
                </div>
            </div>

            {{-- Resumen --}}
            <div class="side-card side-card--info">
                <h3 class="side-title">
                    <span class="side-icon">📋</span>
                    Resumen
                </h3>
                <p class="side-body">
                    Este panel permite visualizar rápidamente el estado de los estudiantes,
                    identificar mayores de edad y mantener control general del sistema académico.
                </p>
            </div>

            {{-- Recomendación --}}
            <div class="side-card side-card--tip">
                <h3 class="side-title">
                    <span class="side-icon">💡</span>
                    Recomendación
                </h3>
                <p class="side-body">
                    Se recomienda hacer seguimiento especial a estudiantes mayores de edad
                    para procesos administrativos, documentación y validaciones legales.
                </p>
            </div>

            {{-- Accesos rápidos --}}
            <div class="side-card">
                <h3 class="side-title">
                    <span class="side-icon">⚡</span>
                    Accesos rápidos
                </h3>
                <div class="quick-links">
                    <a href="#" class="qlink qlink--blue">👥 Estudiantes</a>
                    <a href="#" class="qlink qlink--teal">📚 Materias</a>
                    <a href="#" class="qlink qlink--amber">📝 Notas</a>
                    <a href="#" class="qlink qlink--red">📋 Reportes</a>
                </div>
            </div>

        </aside>
    </div>{{-- /dash-body --}}

</div>{{-- /dash-root --}}

{{-- ── Chart.js ──────────────────────────────────────────── --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const low    = @json($lowSubjects ?? []);
    const top    = @json($topSubjects ?? []);
    const grades = @json($topGrades ?? []);

    const baseOpts = {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: {
                grid: { display: false },
                ticks: { font: { family: "'DM Sans', sans-serif", size: 11 }, color: '#546e7a' }
            },
            y: {
                grid: { color: 'rgba(38,50,56,.06)' },
                ticks: { font: { family: "'DM Sans', sans-serif", size: 11 }, color: '#546e7a' }
            }
        }
    };

    new Chart(document.getElementById('lowChart'), {
        type: 'bar',
        data: {
            labels: low.map(i => i.name),
            datasets: [{
                label: 'Promedio',
                data: low.map(i => i.promedio),
                backgroundColor: 'rgba(239,83,80,.15)',
                borderColor: '#ef5350',
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: baseOpts
    });

    new Chart(document.getElementById('topChart'), {
        type: 'bar',
        data: {
            labels: top.map(i => i.name),
            datasets: [{
                label: 'Promedio',
                data: top.map(i => i.promedio),
                backgroundColor: 'rgba(38,166,154,.15)',
                borderColor: '#26a69a',
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: baseOpts
    });

    new Chart(document.getElementById('gradeChart'), {
        type: 'doughnut',
        data: {
            labels: grades.map(i => i.name),
            datasets: [{
                data: grades.map(i => i.promedio),
                backgroundColor: ['#1e88e5','#26a69a','#f59e0b','#ef5350','#5c6bc0','#80cbc4'],
                borderWidth: 0,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            cutout: '62%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { family: "'DM Sans', sans-serif", size: 11 },
                        color: '#546e7a',
                        padding: 16
                    }
                }
            }
        }
    });
</script>

</x-app-layout>