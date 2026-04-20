

<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/admin/boletin/grade.css'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="container">

    <h2>📚 Estudiantes del grado</h2>

    
    <div class="mb-3">

        <label><strong>Seleccionar periodo:</strong></label>

        <select id="periodSelect" class="form-control">
            <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($period->id); ?>">
                    <?php echo e($period->name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

    </div>

    
    <a id="btnPdfMasivo"
       href="#"
       class="btn btn-danger mb-3">
       📄 Descargar todos los boletines
    </a>

    
    <table class="table table-bordered">

        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Boletines</th>
            </tr>
        </thead>

        <tbody>

            <?php $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <tr>
                    <td>
                        <?php echo e($enrollment->student->first_name); ?>

                        <?php echo e($enrollment->student->last_name); ?>

                    </td>

                    <td>

                        
                        <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <a href="<?php echo e(route('admin.boletin.show', [
                                $enrollment->student_id,
                                $period->id
                            ])); ?>"
                               class="btn btn-info btn-sm">
                                Ver <?php echo e($period->name); ?>

                            </a>

                            <a href="<?php echo e(route('admin.boletin.pdf', [
                                $enrollment->student_id,
                                $period->id
                            ])); ?>"
                               class="btn btn-success btn-sm">
                                PDF
                            </a>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </td>
                </tr>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tbody>

    </table>

</div>


<script>
    const select = document.getElementById('periodSelect');
    const btn = document.getElementById('btnPdfMasivo');

    function updateLink() {
        const periodId = select.value;
        btn.href = `/admin/boletin/grado/<?php echo e($gradeId); ?>/pdf/${periodId}`;
    }

    // inicial
    updateLink();

    // cuando cambia
    select.addEventListener('change', updateLink);
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/boletin/grade.blade.php ENDPATH**/ ?>