<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/dashboard.css'); ?>
<?php $__env->stopPush(); ?>

<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<div class="dash-root">

    
    <section class="hero">
        <div class="hero-orb hero-orb-1"></div>
        <div class="hero-orb hero-orb-2"></div>
        <div class="hero-orb hero-orb-3"></div>

        <div class="hero-content">
            <div class="hero-pills">
                <span class="pill pill-status"><span class="pill-dot"></span>Sistema Activo</span>
                <span class="pill pill-role">🎓 <?php echo e(ucfirst(Auth::user()->role)); ?></span>
            </div>
            <h1 class="hero-title">Hola, <em><?php echo e(Auth::user()->name); ?></em></h1>
            <p class="hero-sub">Panel de control académico · Vista general del sistema</p>
        </div>

        <div class="hero-stats">
            <div class="hstat">
                <span class="hstat-num"><?php echo e($totalStudents ?? 0); ?></span>
                <span class="hstat-label">Total estudiantes</span>
            </div>
            <div class="hstat-sep"></div>
            <div class="hstat">
                <span class="hstat-num hstat-red"><?php echo e($adultStudentsCount ?? 0); ?></span>
                <span class="hstat-label">Mayores de edad</span>
            </div>
            <div class="hstat-sep"></div>
            <div class="hstat">
                <span class="hstat-num hstat-amber"><?php echo e(($totalStudents ?? 0) - ($adultStudentsCount ?? 0)); ?></span>
                <span class="hstat-label">Menores de edad</span>
            </div>
            <div class="hstat-sep"></div>
            <div class="hstat">
                <span class="hstat-num hstat-teal"><?php echo e(count($upcomingStudents ?? [])); ?></span>
                <span class="hstat-label">Próximos a los 18</span>
            </div>
        </div>
    </section>

    
    <div class="dash-body">

        
        <div class="dash-main">

            
            <div class="card">
                <div class="card-head">
                    <div class="card-head-left">
                        <span class="card-icon card-icon--red">18+</span>
                        <div>
                            <h2 class="card-title">Estudiantes mayores de edad</h2>
                            <p class="card-desc">Alumnos con 18 años cumplidos o más</p>
                        </div>
                    </div>
                    <span class="badge badge--red"><?php echo e($adultStudentsCount ?? 0); ?> registros</span>
                </div>

                <?php if(isset($adultStudents) && $adultStudents->count()): ?>
                    <div class="table-scroll">
                        <table class="table">
                            <thead>
                                <tr><th>#</th><th>Nombre</th><th>Edad</th><th>Estado</th></tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $adultStudents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="col-num"><?php echo e($index + 1); ?></td>
                                    <td class="col-name">
                                        <div class="avatar avatar--blue"><?php echo e(strtoupper(substr($student->first_name,0,1))); ?><?php echo e(strtoupper(substr($student->last_name,0,1))); ?></div>
                                        <span><?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?></span>
                                    </td>
                                    <td><span class="chip chip--red"><?php echo e(\Carbon\Carbon::parse($student->birth_date)->age); ?> años</span></td>
                                    <td><span class="chip chip--green"><span class="chip-dot"></span>Activo</span></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state"><span class="empty-icon">🎓</span><p>No hay estudiantes mayores de edad.</p></div>
                <?php endif; ?>
            </div>

            
            <div class="card">
                <div class="card-head">
                    <div class="card-head-left">
                        <span class="card-icon card-icon--amber">⏳</span>
                        <div>
                            <h2 class="card-title">Próximos a cumplir 18 años</h2>
                            <p class="card-desc">Alertas de cambio de mayoría de edad</p>
                        </div>
                    </div>
                    <span class="badge badge--amber"><?php echo e(count($upcomingStudents ?? [])); ?> alertas</span>
                </div>

                <?php if(!empty($upcomingStudents)): ?>
                    <div class="table-scroll">
                        <table class="table">
                            <thead>
                                <tr><th>#</th><th>Nombre</th><th>Días faltantes</th><th>Alerta</th></tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $upcomingStudents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="col-num"><?php echo e($index + 1); ?></td>
                                    <td class="col-name">
                                        <div class="avatar avatar--amber"><?php echo e(strtoupper(substr($student->first_name,0,1))); ?><?php echo e(strtoupper(substr($student->last_name,0,1))); ?></div>
                                        <span><?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?></span>
                                    </td>
                                    <td><span class="chip chip--amber"><?php echo e($student->dias_faltantes); ?> días</span></td>
                                    <td><span class="alert-label"><?php echo e($student->alerta); ?></span></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state"><span class="empty-icon">⏳</span><p>No hay estudiantes próximos a cumplir 18 años.</p></div>
                <?php endif; ?>
            </div>

            
            <div class="card card--charts">
                <div class="card-head">
                    <div class="card-head-left">
                        <span class="card-icon card-icon--blue">👥</span>
                        <div>
                            <h2 class="card-title">Estadísticas de Edades y Género</h2>
                            <p class="card-desc">Distribución de estudiantes por rango de edad y sexo</p>
                        </div>
                    </div>
                </div>

                
                <form method="GET" class="filters-bar" id="ageFiltersForm">
                    <?php if($period): ?><input type="hidden" name="period" value="<?php echo e($period); ?>"><?php endif; ?>

                    <div class="filter-group">
                        <label class="filter-label">Grado</label>
                        <select name="grade_id" class="filter-select" onchange="this.form.submit()">
                            <option value="">Todos los grados</option>
                            <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($g->id); ?>" <?php echo e($gradeId == $g->id ? 'selected' : ''); ?>><?php echo e($g->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">Rango de edad</label>
                        <select name="age_range" class="filter-select" onchange="this.form.submit()">
                            <option value="">Todos</option>
                            <option value="9-12"  <?php echo e(($ageRange ?? '') === '9-12'  ? 'selected' : ''); ?>>9 – 12 años</option>
                            <option value="13-15" <?php echo e(($ageRange ?? '') === '13-15' ? 'selected' : ''); ?>>13 – 15 años</option>
                            <option value="16-19" <?php echo e(($ageRange ?? '') === '16-19' ? 'selected' : ''); ?>>16 – 19 años</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">Año</label>
                        <select name="year" class="filter-select" onchange="this.form.submit()">
                            <option value="">Todos los años</option>
                            <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($y); ?>" <?php echo e(($year ?? '') == $y ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">Género</label>
                        <select name="gender" class="filter-select" onchange="this.form.submit()">
                            <option value="">Todos</option>
                            <option value="masculino" <?php echo e(($genderFilter ?? '') === 'masculino' ? 'selected' : ''); ?>>Masculino</option>
                            <option value="femenino"  <?php echo e(($genderFilter ?? '') === 'femenino'  ? 'selected' : ''); ?>>Femenino</option>
                        </select>
                    </div>

                    <?php if($gradeId || $ageRange || $year || $genderFilter): ?>
                        <a href="<?php echo e(route('dashboard')); ?>" class="filter-clear">✕ Limpiar</a>
                    <?php endif; ?>
                </form>

                
                <div class="age-summary-grid">
                    <?php $__currentLoopData = $ageDistribution; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="age-summary-card">
                        <span class="age-summary-range"><?php echo e($dist['label']); ?></span>
                        <span class="age-summary-count"><?php echo e($dist['count']); ?></span>
                        <span class="age-summary-text">estudiantes</span>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                
                <div class="charts-grid">
                    <div class="chart-box">
                        <p class="chart-label chart-label--blue">📊 Por rango de edad</p>
                        <canvas id="ageRangeChart"></canvas>
                    </div>
                    <div class="chart-box">
                        <p class="chart-label chart-label--teal">⚧ Por género</p>
                        <canvas id="genderChart"></canvas>
                    </div>
                    <div class="chart-box chart-box--full">
                        <p class="chart-label chart-label--indigo">📊 Género por rango de edad</p>
                        <canvas id="genderAgeChart"></canvas>
                    </div>
                </div>
            </div>

            
            <div class="card card--charts">
                <div class="card-head">
                    <div class="card-head-left">
                        <span class="card-icon card-icon--indigo">🎯</span>
                        <div>
                            <h2 class="card-title">Desempeño Académico</h2>
                            <p class="card-desc">Clasificación por niveles: Superior · Alto · Básico · Bajo</p>
                        </div>
                    </div>
                    <form method="GET" class="period-form" id="perfFilterForm">
                        <?php if($gradeId): ?><input type="hidden" name="grade_id" value="<?php echo e($gradeId); ?>"><?php endif; ?>
                        <?php if($year): ?><input type="hidden" name="year" value="<?php echo e($year); ?>"><?php endif; ?>
                        <?php if($genderFilter): ?><input type="hidden" name="gender" value="<?php echo e($genderFilter); ?>"><?php endif; ?>

                        <select name="period" onchange="this.form.submit()" class="period-select">
                            <option value="">Todos los periodos</option>
                            <option value="1" <?php echo e(($period ?? '') == 1 ? 'selected' : ''); ?>>Periodo 1</option>
                            <option value="2" <?php echo e(($period ?? '') == 2 ? 'selected' : ''); ?>>Periodo 2</option>
                            <option value="3" <?php echo e(($period ?? '') == 3 ? 'selected' : ''); ?>>Periodo 3</option>
                        </select>

                        <select name="grade_id" onchange="this.form.submit()" class="period-select">
                            <option value="">Todos los grados</option>
                            <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($g->id); ?>" <?php echo e($gradeId == $g->id ? 'selected' : ''); ?>><?php echo e($g->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </form>
                </div>

                
                <div class="perf-level-cards">
                    <div class="perf-card perf-card--superior">
                        <span class="perf-icon">🌟</span>
                        <span class="perf-count"><?php echo e($studentsByLevel['superior']); ?></span>
                        <span class="perf-label">Superior</span>
                        <span class="perf-range">≥ 4.6</span>
                    </div>
                    <div class="perf-card perf-card--alto">
                        <span class="perf-icon">📈</span>
                        <span class="perf-count"><?php echo e($studentsByLevel['alto']); ?></span>
                        <span class="perf-label">Alto</span>
                        <span class="perf-range">4.0 – 4.5</span>
                    </div>
                    <div class="perf-card perf-card--basico">
                        <span class="perf-icon">📊</span>
                        <span class="perf-count"><?php echo e($studentsByLevel['basico']); ?></span>
                        <span class="perf-label">Básico</span>
                        <span class="perf-range">3.0 – 3.9</span>
                    </div>
                    <div class="perf-card perf-card--bajo">
                        <span class="perf-icon">⚠️</span>
                        <span class="perf-count"><?php echo e($studentsByLevel['bajo']); ?></span>
                        <span class="perf-label">Bajo</span>
                        <span class="perf-range">< 3.0</span>
                    </div>
                </div>

                
                <div class="charts-grid">
                    <div class="chart-box">
                        <p class="chart-label chart-label--indigo">🥧 Notas por nivel</p>
                        <canvas id="perfPieChart"></canvas>
                    </div>
                    <div class="chart-box">
                        <p class="chart-label chart-label--blue">📚 Áreas por nivel</p>
                        <canvas id="subjectLevelChart"></canvas>
                    </div>
                    <div class="chart-box chart-box--full">
                        <p class="chart-label chart-label--teal">🏫 Desempeño por grado</p>
                        <canvas id="gradePerformanceChart"></canvas>
                    </div>
                </div>

                
                <div class="perf-detail-tabs">
                    <?php $__currentLoopData = $performanceLevels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(count($level['subjects']) > 0): ?>
                        <div class="perf-detail-block perf-detail--<?php echo e($key); ?>">
                            <h3 class="perf-detail-title">
                                <?php if($key==='superior'): ?>🌟<?php elseif($key==='alto'): ?>📈<?php elseif($key==='basico'): ?>📊<?php else: ?>⚠️<?php endif; ?>
                                <?php echo e($level['label']); ?>

                                <span class="perf-detail-badge"><?php echo e($level['count']); ?> áreas</span>
                            </h3>
                            <div class="table-scroll">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Área / Materia</th>
                                            <th>Grado</th>
                                            <th>Promedio</th>
                                            <th>Nivel</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $level['subjects']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($subj['subject']); ?></td>
                                            <td><?php echo e($subj['grade']); ?></td>
                                            <td>
                                                <span class="chip chip--<?php echo e($key==='superior'?'blue':($key==='alto'?'teal':($key==='basico'?'amber':'red'))); ?>">
                                                    <?php echo e($subj['promedio']); ?>

                                                </span>
                                            </td>
                                            <td>
                                                <span class="level-badge level-badge--<?php echo e($key); ?>"><?php echo e($level['label']); ?></span>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <div class="card">
                <div class="card-head">
                    <div class="card-head-left">
                        <span class="card-icon card-icon--teal">🏆</span>
                        <div>
                            <h2 class="card-title">Ranking de estudiantes por grado</h2>
                            <p class="card-desc">Top 5 según promedio académico</p>
                        </div>
                    </div>
                </div>

                <?php if(isset($rankingStudents) && count($rankingStudents)): ?>
                    <div class="ranking-grid">
                        <?php $__currentLoopData = $rankingStudents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade => $students): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="ranking-block">
                            <h3 class="ranking-grade-title">🎓 <?php echo e($grade); ?></h3>
                            <table class="table">
                                <thead><tr><th>#</th><th>Estudiante</th><th>Promedio</th></tr></thead>
                                <tbody>
                                    <?php $__currentLoopData = $students->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="col-medal">
                                            <?php if($index===0): ?>🥇<?php elseif($index===1): ?>🥈<?php elseif($index===2): ?>🥉<?php else: ?><span class="medal-num"><?php echo e($index+1); ?></span><?php endif; ?>
                                        </td>
                                        <td class="col-name">
                                            <div class="avatar avatar--teal"><?php echo e(strtoupper(substr($student->first_name,0,1))); ?><?php echo e(strtoupper(substr($student->last_name,0,1))); ?></div>
                                            <span><?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?></span>
                                        </td>
                                        <td><span class="chip chip--blue"><?php echo e(number_format($student->promedio,2)); ?></span></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state"><span class="empty-icon">🏆</span><p>No hay datos de ranking.</p></div>
                <?php endif; ?>
            </div>

            
            <div class="card card--charts">
                <div class="card-head">
                    <div class="card-head-left">
                        <span class="card-icon card-icon--indigo">📊</span>
                        <div>
                            <h2 class="card-title">Análisis Académico</h2>
                            <p class="card-desc">Promedio por materias · las 5 con menor y mayor rendimiento</p>
                        </div>
                    </div>
                    <form method="GET" class="period-form">
                        <?php if($gradeId): ?><input type="hidden" name="grade_id" value="<?php echo e($gradeId); ?>"><?php endif; ?>
                        <?php if($genderFilter): ?><input type="hidden" name="gender" value="<?php echo e($genderFilter); ?>"><?php endif; ?>
                        <select name="period" onchange="this.form.submit()" class="period-select">
                            <option value="">Todos los periodos</option>
                            <option value="1" <?php echo e(($period??'')==1?'selected':''); ?>>Periodo 1</option>
                            <option value="2" <?php echo e(($period??'')==2?'selected':''); ?>>Periodo 2</option>
                            <option value="3" <?php echo e(($period??'')==3?'selected':''); ?>>Periodo 3</option>
                        </select>
                    </form>
                </div>

                
                <div class="chart-reading-note">
                    <span class="note-icon">ℹ️</span>
                    <span>Las gráficas muestran el <strong>promedio de notas</strong> por materia. Las barras rojas son las materias con menor promedio; las verdes, las de mejor rendimiento. Una misma materia puede aparecer en ambas si su promedio está en el rango medio, o solo en una si está en los extremos.</span>
                </div>

                <div class="charts-grid">
                    <div class="chart-box">
                        <p class="chart-label chart-label--red">📉 Menor promedio (Top 5)</p>
                        <canvas id="lowChart"></canvas>
                    </div>
                    <div class="chart-box">
                        <p class="chart-label chart-label--teal">📈 Mayor promedio (Top 5)</p>
                        <canvas id="topChart"></canvas>
                    </div>
                    <div class="chart-box chart-box--full">
                        <p class="chart-label chart-label--blue">🏫 Promedio por grado</p>
                        <canvas id="gradeChart"></canvas>
                    </div>
                </div>
            </div>

        </div>

        
        <aside class="dash-side">

            
            <div class="side-card side-card--status">
                <div class="side-status-row">
                    <span class="status-dot-pulse"></span>
                    <span class="side-status-text">Sistema operativo</span>
                </div>
                <p class="side-status-sub">Todos los módulos funcionando con normalidad.</p>
            </div>

            
            <div class="side-card">
                <h3 class="side-title"><span class="side-icon">🍩</span> Distribución por edad</h3>
                <?php
                    $total  = $totalStudents ?? 1;
                    $adults = $adultStudentsCount ?? 0;
                    $minors = $total - $adults;
                    $pct    = $total > 0 ? round(($adults / $total) * 100) : 0;
                    $circ   = 282;
                    $dash   = round(($pct / 100) * $circ);
                ?>
                <div class="donut-wrap">
                    <svg class="donut-svg" viewBox="0 0 100 100">
                        <circle class="donut-track" cx="50" cy="50" r="45"/>
                        <circle class="donut-arc"   cx="50" cy="50" r="45"
                                stroke-dasharray="<?php echo e($dash); ?> <?php echo e($circ - $dash); ?>"
                                stroke-dashoffset="70"/>
                        <text x="50" y="46" class="donut-pct"><?php echo e($pct); ?>%</text>
                        <text x="50" y="58" class="donut-sub">adultos</text>
                    </svg>
                </div>
                <div class="donut-legend">
                    <span class="leg-item"><span class="leg-dot leg-dot--red"></span>Mayores: <strong><?php echo e($adults); ?></strong></span>
                    <span class="leg-item"><span class="leg-dot leg-dot--amber"></span>Menores: <strong><?php echo e($minors); ?></strong></span>
                </div>
            </div>

            
            <div class="side-card">
                <h3 class="side-title"><span class="side-icon">🎯</span> Resumen de desempeño</h3>
                <?php $totalPerf = array_sum($studentsByLevel); ?>
                <?php $__currentLoopData = ['superior'=>['color'=>'#1e88e5','label'=>'Superior'],'alto'=>['color'=>'#26a69a','label'=>'Alto'],'basico'=>['color'=>'#f59e0b','label'=>'Básico'],'bajo'=>['color'=>'#ef5350','label'=>'Bajo']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $cnt = $studentsByLevel[$key] ?? 0; $pctLevel = $totalPerf > 0 ? round(($cnt/$totalPerf)*100) : 0; ?>
                    <div class="perf-bar-row">
                        <span class="perf-bar-label"><?php echo e($info['label']); ?></span>
                        <div class="perf-bar-track">
                            <div class="perf-bar-fill" style="width:<?php echo e($pctLevel); ?>%;background:<?php echo e($info['color']); ?>"></div>
                        </div>
                        <span class="perf-bar-pct"><?php echo e($pctLevel); ?>%</span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <div class="side-card">
                <h3 class="side-title"><span class="side-icon">📚</span> Top áreas</h3>
                <?php $__empty_1 = true; $__currentLoopData = $topSubjects->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="side-subject-row">
                    <span class="side-subject-name"><?php echo e($sub->name); ?></span>
                    <span class="chip chip--teal"><?php echo e($sub->promedio); ?></span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="side-empty">Sin datos</p>
                <?php endif; ?>
            </div>

            
            <div class="side-card side-card--info">
                <h3 class="side-title"><span class="side-icon">📋</span> Resumen</h3>
                <p class="side-body">Este panel permite visualizar el estado de los estudiantes, identificar mayores de edad y mantener control del sistema académico.</p>
            </div>

            
            <div class="side-card side-card--tip">
                <h3 class="side-title"><span class="side-icon">💡</span> Recomendación</h3>
                <p class="side-body">Se recomienda hacer seguimiento a estudiantes mayores de edad para procesos administrativos y validaciones legales.</p>
            </div>

            
            <div class="side-card">
                <h3 class="side-title"><span class="side-icon">⚡</span> Accesos rápidos</h3>
                <div class="quick-links">
                    <a href="#" class="qlink qlink--blue">👥 Estudiantes</a>
                    <a href="#" class="qlink qlink--teal">📚 Materias</a>
                    <a href="#" class="qlink qlink--amber">📝 Notas</a>
                    <a href="#" class="qlink qlink--red">📋 Reportes</a>
                </div>
            </div>

        </aside>
    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const lowSubjects        = <?php echo json_encode($lowSubjects ?? [], 15, 512) ?>;
    const topSubjects        = <?php echo json_encode($topSubjects ?? [], 15, 512) ?>;
    const topGrades          = <?php echo json_encode($topGrades ?? [], 15, 512) ?>;
    const ageDistribution    = <?php echo json_encode($ageDistribution ?? [], 15, 512) ?>;
    const genderDistribution = <?php echo json_encode($genderDistribution ?? [], 15, 512) ?>;
    const genderByAgeRange   = <?php echo json_encode($genderByAgeRange ?? [], 15, 512) ?>;
    const studentsByLevel    = <?php echo json_encode($studentsByLevel ?? [], 15, 512) ?>;
    const performanceLevels  = <?php echo json_encode($performanceLevels ?? [], 15, 512) ?>;
    const performanceByGrade = <?php echo json_encode($performanceByGrade ?? [], 15, 512) ?>;

    // Eliminar duplicados por nombre
    function unique(arr) {
        const seen = new Set();
        return arr.filter(i => { const k = (i.name||'').trim().toLowerCase(); if(seen.has(k)) return false; seen.add(k); return true; });
    }

    const lowFiltered = unique(lowSubjects);
    const topFiltered = unique(topSubjects);

    Chart.defaults.font.family = "'DM Sans', sans-serif";

    const base = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { labels: { color: '#546e7a' } } },
        scales: {
            x: { ticks: { color: '#546e7a' }, grid: { display: false } },
            y: { ticks: { color: '#546e7a' }, grid: { color: 'rgba(0,0,0,.05)' }, beginAtZero: true }
        }
    };

    // Edad
    const ageCtx = document.getElementById('ageRangeChart');
    if (ageCtx) new Chart(ageCtx, { type:'bar', data:{ labels: ageDistribution.map(i=>i.label), datasets:[{ label:'Estudiantes', data: ageDistribution.map(i=>i.count), backgroundColor:['rgba(30,136,229,.6)','rgba(38,166,154,.6)','rgba(92,107,192,.6)'], borderRadius:10 }] }, options: base });

    // Género donut
    const genCtx = document.getElementById('genderChart');
    if (genCtx) new Chart(genCtx, { type:'doughnut', data:{ labels:['Masculino','Femenino'], datasets:[{ data:[genderDistribution.M?.count??0, genderDistribution.F?.count??0], backgroundColor:['rgba(30,136,229,.8)','rgba(239,83,80,.8)'], borderWidth:0 }] }, options:{ responsive:true, maintainAspectRatio:false, cutout:'60%' } });

    // Género por edad
    const gaCtx = document.getElementById('genderAgeChart');
    if (gaCtx) new Chart(gaCtx, { type:'bar', data:{ labels: genderByAgeRange.map(i=>i.range), datasets:[{ label:'Masculino', data: genderByAgeRange.map(i=>i.masculino), backgroundColor:'rgba(30,136,229,.7)', borderRadius:8 },{ label:'Femenino', data: genderByAgeRange.map(i=>i.femenino), backgroundColor:'rgba(239,83,80,.7)', borderRadius:8 }] }, options: base });

    // Pie desempeño
    const pieCtx = document.getElementById('perfPieChart');
    if (pieCtx) new Chart(pieCtx, { type:'doughnut', data:{ labels:['Superior','Alto','Básico','Bajo'], datasets:[{ data:[studentsByLevel.superior??0,studentsByLevel.alto??0,studentsByLevel.basico??0,studentsByLevel.bajo??0], backgroundColor:['rgba(30,136,229,.8)','rgba(38,166,154,.8)','rgba(245,158,11,.8)','rgba(239,83,80,.8)'], borderWidth:0 }] }, options:{ responsive:true, maintainAspectRatio:false, cutout:'60%' } });

    // Áreas por nivel
    const slCtx = document.getElementById('subjectLevelChart');
    if (slCtx) new Chart(slCtx, { type:'bar', data:{ labels: Object.keys(performanceLevels).map(k=>performanceLevels[k].label), datasets:[{ label:'Áreas', data: Object.keys(performanceLevels).map(k=>performanceLevels[k].count), backgroundColor:['rgba(30,136,229,.7)','rgba(38,166,154,.7)','rgba(245,158,11,.7)','rgba(239,83,80,.7)'], borderRadius:8 }] }, options: base });

    // Desempeño por grado (apilado)
    const gpCtx = document.getElementById('gradePerformanceChart');
    if (gpCtx) new Chart(gpCtx, { type:'bar', data:{ labels: performanceByGrade.map(i=>i.grade), datasets:[{ label:'Superior', data: performanceByGrade.map(i=>i.superior), backgroundColor:'rgba(30,136,229,.8)' },{ label:'Alto', data: performanceByGrade.map(i=>i.alto), backgroundColor:'rgba(38,166,154,.8)' },{ label:'Básico', data: performanceByGrade.map(i=>i.basico), backgroundColor:'rgba(245,158,11,.8)' },{ label:'Bajo', data: performanceByGrade.map(i=>i.bajo), backgroundColor:'rgba(239,83,80,.8)' }] }, options:{ responsive:true, maintainAspectRatio:false, scales:{ x:{ stacked:true }, y:{ stacked:true, beginAtZero:true } } } });

    // Bajo rendimiento
    const lowCtx = document.getElementById('lowChart');
    if (lowCtx) new Chart(lowCtx, { type:'bar', data:{ labels: lowFiltered.map(i=>i.name), datasets:[{ label:'Promedio', data: lowFiltered.map(i=>i.promedio), backgroundColor:'rgba(239,83,80,.7)', borderRadius:8 }] }, options:{ ...base, scales:{ ...base.scales, y:{ ...base.scales.y, min: 0, max: 5, ticks:{ stepSize:.5, color:'#546e7a' } } } } });

    // Mejor rendimiento
    const topCtx = document.getElementById('topChart');
    if (topCtx) new Chart(topCtx, { type:'bar', data:{ labels: topFiltered.map(i=>i.name), datasets:[{ label:'Promedio', data: topFiltered.map(i=>i.promedio), backgroundColor:'rgba(38,166,154,.7)', borderRadius:8 }] }, options:{ ...base, scales:{ ...base.scales, y:{ ...base.scales.y, min: 0, max: 5, ticks:{ stepSize:.5, color:'#546e7a' } } } } });

    // Promedio por grado (donut)
    const gcCtx = document.getElementById('gradeChart');
    if (gcCtx) new Chart(gcCtx, { type:'doughnut', data:{ labels: topGrades.map(i=>i.name), datasets:[{ data: topGrades.map(i=>i.promedio), backgroundColor:['#1e88e5','#26a69a','#f59e0b','#ef5350','#7e57c2','#42a5f5','#66bb6a'], borderWidth:0 }] }, options:{ responsive:true, maintainAspectRatio:false, cutout:'60%' } });

});
</script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/dashboard.blade.php ENDPATH**/ ?>