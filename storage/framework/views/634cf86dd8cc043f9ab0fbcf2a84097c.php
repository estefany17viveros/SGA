<?php $__env->startSection('title', 'Registro de Notas'); ?>

<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/teacher/score/index.css'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="container">

    
    <div class="header-card d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>📊 Registro de Notas</h2>
            <p class="header-meta">
                <span><strong>Asignatura:</strong> <?php echo e($assignment->subject->name); ?></span>
                <span><strong>Grado:</strong> <?php echo e($assignment->grade->name); ?></span>
                <span><strong>Trimestre:</strong> <?php echo e($period->name ?? 'Sin trimestre activo'); ?></span>
            </p>
        </div>
        <a href="<?php echo e(route('teacher.dashboard')); ?>" class="btn btn-volver">
            ⬅ Volver
        </a>
    </div>

    
    <?php if(isset($period)): ?>
    <div class="excel-bar mb-3">
        <a href="<?php echo e(route('teacher.scores.export', $assignment->id)); ?>" class="btn btn-excel-download">
            📥 Descargar Plantilla Excel
        </a>

        <form action="<?php echo e(route('teacher.scores.import')); ?>" method="POST"
              enctype="multipart/form-data" class="excel-form">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="teacher_subject_id" value="<?php echo e($assignment->id); ?>">
            <input type="hidden" name="period_id"          value="<?php echo e($period->id); ?>">
            <input type="file" name="file" class="form-control file-input" required>
            <button type="submit" class="btn btn-excel-upload">📤 Subir Excel</button>
        </form>
    </div>
    <?php endif; ?>

    
    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    
    <?php if(!isset($period)): ?>
        <div class="alert alert-warning">
            ⚠ No hay periodo activo. Contacta al administrador.
        </div>

    <?php else: ?>

    
    <form action="<?php echo e(route('teacher.scores.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="teacher_subject_id" value="<?php echo e($assignment->id); ?>">
        <input type="hidden" name="period_id"          value="<?php echo e($period->id); ?>">

        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="tabla-notas">

                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th class="col-nombre">Estudiante</th>
                        <th>Saber <span class="th-pct">33%</span></th>
                        <th>Hacer <span class="th-pct">33%</span></th>
                        <th>Ser <span class="th-pct">33%</span></th>
                        <th>F. Just.</th>
                        <th>F. Injust.</th>
                        <th>Promedio</th>
                        <th>Puesto</th>
                    </tr>
                </thead>

                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $ranking; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $student = $item['student'];
                        $score   = $item['score'];
                    ?>

                    <tr>
                        
                        <td class="text-center td-num"><?php echo e($loop->iteration); ?></td>

                        
                        <td class="td-nombre"><?php echo e($student->full_name); ?></td>

                        
                        <td>
                            <input type="number" step="0.1" min="1" max="5"
                                class="form-control nota"
                                data-id="<?php echo e($student->id); ?>" data-type="saber"
                                name="scores[<?php echo e($student->id); ?>][saber]"
                                value="<?php echo e(isset($score->saber)
                                    ? number_format(floor($score->saber * 10) / 10, 1, '.', '')
                                    : ''); ?>">
                        </td>

                        
                        <td>
                            <input type="number" step="0.1" min="1" max="5"
                                class="form-control nota"
                                data-id="<?php echo e($student->id); ?>" data-type="hacer"
                                name="scores[<?php echo e($student->id); ?>][hacer]"
                                value="<?php echo e(isset($score->hacer)
                                    ? number_format(floor($score->hacer * 10) / 10, 1, '.', '')
                                    : ''); ?>">
                        </td>

                        
                        <td>
                            <input type="number" step="0.1" min="1" max="5"
                                class="form-control nota"
                                data-id="<?php echo e($student->id); ?>" data-type="ser"
                                name="scores[<?php echo e($student->id); ?>][ser]"
                                value="<?php echo e(isset($score->ser)
                                    ? number_format(floor($score->ser * 10) / 10, 1, '.', '')
                                    : ''); ?>">
                        </td>

                        
                        <td>
                            <input type="number" min="0"
                                class="form-control input-ausencia"
                                name="scores[<?php echo e($student->id); ?>][justified_absences]"
                                value="<?php echo e($score->justified_absences ?? 0); ?>">
                        </td>

                        
                        <td>
                            <input type="number" min="0"
                                class="form-control input-ausencia"
                                name="scores[<?php echo e($student->id); ?>][unjustified_absences]"
                                value="<?php echo e($score->unjustified_absences ?? 0); ?>">
                        </td>

                        
                        <td class="text-center">
                            <span class="badge-promedio" id="total-<?php echo e($student->id); ?>">
                                <?php echo e(isset($score->total)
                                    ? number_format(floor($score->total * 10) / 10, 1, '.', '')
                                    : '—'); ?>

                            </span>
                        </td>

                        
                        <td class="text-center">
                            <span class="badge-puesto puesto-<?php echo e($loop->iteration <= 3 ? $loop->iteration : 'resto'); ?>">
                                <?php echo e($item['position']); ?>

                            </span>
                        </td>
                    </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" class="text-center td-vacio">
                            😕 No hay estudiantes registrados
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>

            </table>
        </div>

        <div class="guardar-bar mt-3 text-end">
            <button type="submit" class="btn btn-guardar">
                💾 Guardar Notas
            </button>
        </div>
    </form>

    <?php endif; ?>
</div>

<script>
function truncar(num, dec) {
    return Math.floor(num * Math.pow(10, dec)) / Math.pow(10, dec);
}

function calcularColor(val) {
    if (isNaN(val)) return '';
    if (val >= 4.5) return 'promedio-superior';
    if (val >= 4.0) return 'promedio-alto';
    if (val >= 3.0) return 'promedio-basico';
    return 'promedio-bajo';
}

document.querySelectorAll('.nota').forEach(input => {
    input.addEventListener('input', function () {
        const id    = this.dataset.id;
        const saber = parseFloat(document.querySelector(`[data-id="${id}"][data-type="saber"]`)?.value);
        const hacer = parseFloat(document.querySelector(`[data-id="${id}"][data-type="hacer"]`)?.value);
        const ser   = parseFloat(document.querySelector(`[data-id="${id}"][data-type="ser"]`)?.value);
        const cell  = document.getElementById('total-' + id);

        // Limpiar clases de color
        cell.className = 'badge-promedio';

        if (!isNaN(saber) && !isNaN(hacer) && !isNaN(ser)) {
            const total = truncar((saber + hacer + ser) / 3, 1);
            cell.textContent = total.toFixed(1);
            cell.classList.add(calcularColor(total));
        } else {
            cell.textContent = '—';
        }
    });
});

// Colorear promedios ya cargados al inicio
document.querySelectorAll('.badge-promedio').forEach(cell => {
    const val = parseFloat(cell.textContent);
    if (!isNaN(val)) cell.classList.add(calcularColor(val));
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/teacher/scores/index.blade.php ENDPATH**/ ?>