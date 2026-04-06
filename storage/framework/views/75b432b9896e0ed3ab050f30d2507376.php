

<?php $__env->startSection('title', 'Sistema Académico'); ?>

<?php $__env->startSection('content'); ?>

<div class="container">
    <h2>📊 Sistema Académico</h2>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    
    <form method="GET">
        <div class="mb-3">
            <label><strong>Seleccionar grado</strong></label>
            <select name="grade_id" class="form-control" onchange="this.form.submit()">
                <option value="">Seleccione...</option>
                <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($grade->id); ?>" 
                        <?php echo e(request('grade_id') == $grade->id ? 'selected' : ''); ?>>
                        <?php echo e($grade->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </form>

    
    <?php if($activities->count()): ?>

        <?php $__currentLoopData = ['saber','hacer','ser']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <?php echo e(strtoupper($type)); ?>

                </div>

                <div class="card-body">

                    <?php $__empty_1 = true; $__currentLoopData = $activities[$type] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <button class="btn btn-info mb-2"
                                onclick="toggle(<?php echo e($activity->id); ?>)">
                            <?php echo e($activity->description); ?> (<?php echo e($activity->percentage); ?>%)
                        </button>

                        
                        <div id="activity-<?php echo e($activity->id); ?>" style="display:none">
                            <?php echo $__env->make('teacher.activities.partials.students', [
                                'activity' => $activity,
                                'students' => $students
                            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p>No hay actividades</p>
                    <?php endif; ?>

                </div>
            </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php endif; ?>

</div>

<script>
function toggle(id){
    let el = document.getElementById('activity-' + id);
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/teacher/activities/index.blade.php ENDPATH**/ ?>