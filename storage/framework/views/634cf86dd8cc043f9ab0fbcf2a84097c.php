<?php $__env->startSection('title', 'Registro de Notas'); ?>

<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/teacher/score/index.css'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="container">

    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>📊 Registro de Notas</h2>
            <p class="mb-0">
                <strong>Materia:</strong> <?php echo e($assignment->subject->name); ?> |
                <strong>Grado:</strong> <?php echo e($assignment->grade->name); ?> |
                <strong>Periodo:</strong> <?php echo e($period->name ?? 'Sin periodo activo'); ?>

            </p>
        </div>

        <a href="<?php echo e(route('teacher.dashboard')); ?>" class="btn btn-secondary">
            ⬅ Volver
        </a>
    </div>

    
    <?php if(isset($period)): ?>
    <div class="mb-3 d-flex gap-2">

        
        <a href="<?php echo e(route('teacher.scores.export', $assignment->id)); ?>" class="btn btn-success">
            📥 Descargar Plantilla Excel
        </a>

        
        <form action="<?php echo e(route('teacher.scores.import')); ?>" method="POST" enctype="multipart/form-data" class="d-flex gap-2">
            <?php echo csrf_field(); ?>

            <input type="hidden" name="teacher_subject_id" value="<?php echo e($assignment->id); ?>">
            <input type="hidden" name="period_id" value="<?php echo e($period->id); ?>">

            <input type="file" name="file" class="form-control" required>

            <button type="submit" class="btn btn-primary">
                📤 Subir Excel
            </button>
        </form>

    </div>
    <?php endif; ?>

    
    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    
    <?php if(!isset($period)): ?>
        <div class="alert alert-warning">
            ⚠ No hay periodo activo. Contacta al administrador.
        </div>
    <?php else: ?>

    
    <form action="<?php echo e(route('teacher.scores.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <input type="hidden" name="teacher_subject_id" value="<?php echo e($assignment->id); ?>">
        <input type="hidden" name="period_id" value="<?php echo e($period->id); ?>">

        <div class="table-responsive">
            <table class="table table-bordered table-striped">

                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Estudiante</th>
                        <th>Saber (33%)</th>
                        <th>Hacer (33%)</th>
                        <th>Ser (33%)</th>
                        <th>Total</th>
                        <th>Puesto</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    function nota($n) {
                        return $n !== null 
                            ? rtrim(rtrim(number_format($n, 2, '.', ''), '0'), '.') 
                            : '';
                    }
                    ?>

                    <?php $__empty_1 = true; $__currentLoopData = $ranking; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <?php
                            $student = $item['student'];
                            $score   = $item['score'];
                        ?>

                        <tr>
                            <td class="text-center"><?php echo e($loop->iteration); ?></td>

                            <td><?php echo e($student->full_name); ?></td>

                            
                            <td>
                                <input type="number"
                                    step="0.01"
                                    min="1"
                                    max="5"
                                    class="form-control nota"
                                    data-id="<?php echo e($student->id); ?>"
                                    data-type="saber"
                                    name="scores[<?php echo e($student->id); ?>][saber]"
                                    value="<?php echo e(isset($score->saber) ? number_format($score->saber, 2, '.', '') : ''); ?>">
                            </td>

                            
                            <td>
                                <input type="number"
                                    step="0.01"
                                    min="1"
                                    max="5"
                                    class="form-control nota"
                                    data-id="<?php echo e($student->id); ?>"
                                    data-type="hacer"
                                    name="scores[<?php echo e($student->id); ?>][hacer]"
                                    value="<?php echo e(isset($score->hacer) ? number_format($score->hacer, 2, '.', '') : ''); ?>">
                            </td>

                            
                            <td>
                                <input type="number"
                                    step="0.01"
                                    min="1"
                                    max="5"
                                    class="form-control nota"
                                    data-id="<?php echo e($student->id); ?>"
                                    data-type="ser"
                                    name="scores[<?php echo e($student->id); ?>][ser]"
                                    value="<?php echo e(isset($score->ser) ? number_format($score->ser, 2, '.', '') : ''); ?>">
                            </td>

                            
                            <td class="text-center">
                                <strong id="total-<?php echo e($student->id); ?>">
                                    <?php echo e(isset($score->total) ? number_format($score->total, 2, '.', '') : '-'); ?>

                                </strong>
                            </td>

                            
                            <td class="text-center">
                                <span class="badge bg-warning text-dark">
                                    <?php echo e($item['position']); ?>

                                </span>
                            </td>

                        </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <tr>
                            <td colspan="7" class="text-center">
                                No hay estudiantes registrados
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>
        </div>

        
        <div class="mt-3 text-end">
            <button class="btn btn-primary">
                💾 Guardar Notas
            </button>
        </div>

    </form>

    <?php endif; ?>

</div>


<script>
function truncateDecimals(num, decimals) {
    let factor = Math.pow(10, decimals);
    return Math.floor(num * factor) / factor;
}

document.querySelectorAll('.nota').forEach(input => {

    input.addEventListener('input', function () {

        let id = this.dataset.id;

        let saber = parseFloat(document.querySelector(`[data-id="${id}"][data-type="saber"]`)?.value);
        let hacer = parseFloat(document.querySelector(`[data-id="${id}"][data-type="hacer"]`)?.value);
        let ser   = parseFloat(document.querySelector(`[data-id="${id}"][data-type="ser"]`)?.value);

        let totalCell = document.getElementById('total-' + id);

        if (!isNaN(saber) && !isNaN(hacer) && !isNaN(ser)) {

            let total = (saber + hacer + ser) / 3;
            let totalTruncado = truncateDecimals(total, 2);

            totalCell.innerText = totalTruncado.toFixed(2);

        } else {
            totalCell.innerText = '-';
        }

    });

});
</script>

<?php $__env->stopSection(); ?>
 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/teacher/scores/index.blade.php ENDPATH**/ ?>