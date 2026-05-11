

<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/teacher/students.css'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<?php
    use App\Models\AcademicYear;
    use App\Models\Period;

    $year    = AcademicYear::where('status', 'activo')->first();
    $periods = collect();

    if ($year) {
        $periods = Period::where('academic_year_id', $year->id)
            ->orderBy('number')
            ->get();
    }

    $studentsSorted = $students->sortBy(function ($student) {
        $parts = preg_split('/\s+/', trim($student->full_name));
        $total = count($parts);
        if ($total >= 4) {
            return strtolower($parts[$total - 2] . ' ' . $parts[$total - 1]);
        }
        return strtolower($student->full_name);
    })->values();
?>

<div class="container">

    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>👨‍🎓 Estudiantes</h2>
        <a href="<?php echo e(route('teacher.scores.index', $teacher_subject_id)); ?>" class="btn btn-primary">
            📊 Gestionar Notas
        </a>
    </div>

    <a href="<?php echo e(route('teacher.dashboard')); ?>" class="mb-3 d-inline-block">⬅ Volver al inicio</a>

    
    <div class="filtros-wrapper">

        
        <div class="filtros-grupo">
            <span class="filtros-label">📅 Filtrar por periodo:</span>
            <div class="filtros-botones">
                <button class="filtro-btn filtro-periodo activo"
                        data-periodo="todos"
                        onclick="aplicarFiltros(this, null)">
                    📋 Todos los periodos
                </button>
                <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button class="filtro-btn filtro-periodo"
                            data-periodo="<?php echo e($period->id); ?>"
                            onclick="aplicarFiltros(this, null)">
                        P<?php echo e($period->number); ?>

                    </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        
        <div class="filtros-grupo">
            <span class="filtros-label">🎯 Filtrar por escala:</span>
            <div class="filtros-botones">
                <button class="filtro-btn filtro-escala activo"
                        data-escala="todas"
                        onclick="aplicarFiltros(null, this)">
                    📋 Todas las escalas
                </button>
                <button class="filtro-btn filtro-escala bajo"
                        data-escala="bajo"
                        onclick="aplicarFiltros(null, this)">
                    🔴 Bajo <span class="filtro-rango">1.0 – 2.9</span>
                </button>
                <button class="filtro-btn filtro-escala basico"
                        data-escala="basico"
                        onclick="aplicarFiltros(null, this)">
                    🟡 Básico <span class="filtro-rango">3.0 – 3.9</span>
                </button>
                <button class="filtro-btn filtro-escala alto"
                        data-escala="alto"
                        onclick="aplicarFiltros(null, this)">
                    🔵 Alto <span class="filtro-rango">4.0 – 4.4</span>
                </button>
                <button class="filtro-btn filtro-escala superior"
                        data-escala="superior"
                        onclick="aplicarFiltros(null, this)">
                    🟢 Superior <span class="filtro-rango">4.5 – 5.0</span>
                </button>
            </div>
        </div>

        <span class="filtros-contador" id="contador">Cargando...</span>
    </div>

    
    <div class="table-responsive">
        <table class="table table-bordered" id="tabla-estudiantes">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th class="th-periodo" data-period-id="<?php echo e($period->id); ?>">
    P<?php echo e($period->number); ?>

</th>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <th>Promedio</th>
                    <th>Escala General</th>
                    <th>Puesto</th>
                </tr>
            </thead>
            <tbody>

                <?php $__empty_1 = true; $__currentLoopData = $studentsSorted; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $student->loadMissing('scores');

                        $totalFinal   = 0;
                        $count        = 0;
                        $periodTotals = [];   // [period_id => value|null]
                        $periodEscalas = []; // [period_id => escala_slug]

                        foreach ($periods as $period) {
                            $score = $student->scores
                                ->where('teacher_subject_id', $teacher_subject_id)
                                ->where('period_id', $period->id)
                                ->first();
                            $value = $score->total ?? null;

                            if (!is_null($value)) {
                                $totalFinal += $value;
                                $count++;
                            }

                            $periodTotals[$period->id] = $value;

                            // Escala por periodo individual
                            if (is_null($value)) {
                                $periodEscalas[$period->id] = 'sin-nota';
                            } elseif ($value >= 4.5) {
                                $periodEscalas[$period->id] = 'superior';
                            } elseif ($value >= 4.0) {
                                $periodEscalas[$period->id] = 'alto';
                            } elseif ($value >= 3.0) {
                                $periodEscalas[$period->id] = 'basico';
                            } else {
                                $periodEscalas[$period->id] = 'bajo';
                            }
                        }

                        $averageFinal = $count > 0 ? floor(($totalFinal / $count) * 10) / 10 : 0;

                        if ($averageFinal >= 4.5)     { $escala = 'superior'; $escalaLabel = 'Superior'; }
                        elseif ($averageFinal >= 4.0) { $escala = 'alto';     $escalaLabel = 'Alto'; }
                        elseif ($averageFinal >= 3.0) { $escala = 'basico';   $escalaLabel = 'Básico'; }
                        elseif ($averageFinal >= 1.0) { $escala = 'bajo';     $escalaLabel = 'Bajo'; }
                        else                          { $escala = 'sin-nota'; $escalaLabel = 'Sin nota'; }

                        // Posición global
                        $position = 1;
                        foreach ($studentsSorted as $index => $s) {
                            $sTotal = 0; $sCount = 0;
                            foreach ($periods as $p) {
                                $sc = $s->scores
                                    ->where('teacher_subject_id', $teacher_subject_id)
                                    ->where('period_id', $p->id)
                                    ->first();
                                if ($sc && $sc->total !== null) { $sTotal += $sc->total; $sCount++; }
                            }
                            $sAvg = $sCount > 0 ? floor(($sTotal / $sCount) * 10) / 10 : 0;

                            if ($index > 0) {
                                $prev = $studentsSorted[$index - 1];
                                $prevTotal = 0; $prevCount = 0;
                                foreach ($periods as $p) {
                                    $psc = $prev->scores
                                        ->where('teacher_subject_id', $teacher_subject_id)
                                        ->where('period_id', $p->id)
                                        ->first();
                                    if ($psc && $psc->total !== null) { $prevTotal += $psc->total; $prevCount++; }
                                }
                                $prevAvg = $prevCount > 0 ? floor(($prevTotal / $prevCount) * 10) / 10 : 0;
                                if ($sAvg != $prevAvg) { $position = $index + 1; }
                            }
                            if ($s->id == $student->id) break;
                        }

                        // Serializar escalas por periodo para data-attribute (JSON)
                        $periodEscalasJson = json_encode($periodEscalas);
                    ?>

                    <tr class="fila-estudiante"
                        data-escala-general="<?php echo e($escala); ?>"
                        data-escalas-periodo="<?php echo e($periodEscalasJson); ?>">

                        <td class="celda-numero"><?php echo e($loop->iteration); ?></td>
                        <td class="celda-nombre"><?php echo e($student->full_name); ?></td>

                        <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $val = $periodTotals[$period->id];
                                $esc = $periodEscalas[$period->id];
                            ?>
                            <td class="text-center celda-periodo" data-period-id="<?php echo e($period->id); ?>">
                                <span class="badge-periodo escala-<?php echo e($esc); ?>">
                                    <?php echo e(!is_null($val)
                                        ? number_format(floor($val * 10) / 10, 1, '.', '')
                                        : '—'); ?>

                                </span>
                            </td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <td class="text-center">
                            <span class="badge-promedio escala-<?php echo e($escala); ?>">
                                <?php echo e(number_format($averageFinal, 1, '.', '')); ?>

                            </span>
                        </td>

                        <td class="text-center">
                            <span class="badge-escala escala-<?php echo e($escala); ?>">
                                <?php echo e($escalaLabel); ?>

                            </span>
                        </td>

                        <td class="text-center">
                            <span class="badge-puesto"><?php echo e($position); ?></span>
                        </td>
                    </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="<?php echo e($periods->count() + 5); ?>" class="text-center text-muted py-3">
                            No hay estudiantes registrados.
                        </td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>

        <div class="sin-resultados d-none" id="sin-resultados">
            😕 Sin estudiantes para la combinación de filtros seleccionada.
        </div>
    </div>

</div>

<script>
    // Estado activo de los dos filtros
    let filtroPeriodo = 'todos';
    let filtroEscala  = 'todas';

    /**
     * @param {HTMLElement|null} btnPeriodo  — el botón de periodo pulsado (null si no cambia)
     * @param {HTMLElement|null} btnEscala   — el botón de escala pulsado (null si no cambia)
     */
    function aplicarFiltros(btnPeriodo, btnEscala) {

        // Actualizar estado y botones activos
        if (btnPeriodo) {
            document.querySelectorAll('.filtro-periodo').forEach(b => b.classList.remove('activo'));
            btnPeriodo.classList.add('activo');
            filtroPeriodo = btnPeriodo.dataset.periodo;
        }

        if (btnEscala) {
            document.querySelectorAll('.filtro-escala').forEach(b => b.classList.remove('activo'));
            btnEscala.classList.add('activo');
            filtroEscala = btnEscala.dataset.escala;
        }

        const filas = document.querySelectorAll('.fila-estudiante');
        let visible = 0;
        let num = 1;

        filas.forEach(fila => {
           const escalasObj = JSON.parse(fila.dataset.escalasPeriodo || '{}');
const escalaGeneral = fila.dataset.escalaGeneral;
            let escalaMostrar;

            if (filtroPeriodo === 'todos') {
                // Sin filtro de periodo → usamos la escala del promedio general
                escalaMostrar = escalaGeneral;
            } else {
                // Con periodo seleccionado → usamos la escala de ese periodo
                escalaMostrar = escalasObj[filtroPeriodo] ?? 'sin-nota';
            }
const pasaPeriodo = filtroPeriodo === 'todos'
    || escalasObj[filtroPeriodo] !== 'sin-nota';
           const pasaEscala  = filtroEscala  === 'todas'  || escalaMostrar === filtroEscala;

            const mostrar = pasaPeriodo && pasaEscala;
            fila.style.display = mostrar ? '' : 'none';

            // Resaltar la columna del periodo seleccionado
            fila.querySelectorAll('.celda-periodo').forEach(td => {
                td.classList.toggle(
                    'columna-resaltada',
                    filtroPeriodo !== 'todos' && td.dataset.periodId === filtroPeriodo
                );
            });

            if (mostrar) {
                fila.querySelector('.celda-numero').textContent = num++;
                visible++;
            }
        });

        // Resaltar th del periodo seleccionado
        document.querySelectorAll('th.th-periodo').forEach(th => {
            th.classList.toggle('columna-resaltada', th.dataset.periodId === filtroPeriodo);
        });

        actualizarContador(visible);
        document.getElementById('sin-resultados').classList.toggle('d-none', visible > 0);
    }

    function actualizarContador(visible) {
        const lblPeriodo = filtroPeriodo === 'todos'
            ? 'todos los periodos'
            : 'P' + document.querySelector(`.filtro-periodo[data-periodo="${filtroPeriodo}"]`)
                         ?.textContent.trim();

        const lblEscala = filtroEscala === 'todas'
            ? 'todas las escalas'
            : document.querySelector(`.filtro-escala[data-escala="${filtroEscala}"]`)
                       ?.textContent.trim() ?? filtroEscala;

        document.getElementById('contador').textContent =
            `${visible} estudiante(s) — ${lblPeriodo} · ${lblEscala}`;
    }

    document.addEventListener('DOMContentLoaded', () => {
        const total = document.querySelectorAll('.fila-estudiante').length;
        document.getElementById('contador').textContent = `${total} estudiante(s)`;
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/teacher/students.blade.php ENDPATH**/ ?>