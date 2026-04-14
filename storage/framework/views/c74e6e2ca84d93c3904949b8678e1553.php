

<?php $__env->startSection('content'); ?>

<div class="container">

    <h3 class="mb-4">📝 Comentarios por Dimensión</h3>

    
    <form method="GET" action="<?php echo e(route('teacher.dimension_comments.index')); ?>" class="mb-3">

        <label class="form-label">Seleccionar materia</label>
        <select name="teacher_subject_id" class="form-control mb-2" onchange="this.form.submit()">
            <option value="">-- Seleccione --</option>

            <?php $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($a->id); ?>"
                    <?php echo e(request('teacher_subject_id') == $a->id ? 'selected' : ''); ?>>
                    <?php echo e($a->subject->name); ?> - <?php echo e($a->grade->name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        
        <label class="form-label">Seleccionar período</label>
        <select name="period_id" class="form-control" onchange="this.form.submit()">
            <option value="">-- Seleccione período --</option>

            <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($period->id); ?>"
                    <?php echo e(request('period_id') == $period->id ? 'selected' : ''); ?>>
                    <?php echo e($period->name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

    </form>

    <?php if($assignment): ?>

        <p class="mb-3">
            <strong>Materia:</strong> <?php echo e($assignment->subject->name); ?> |
            <strong>Grado:</strong> <?php echo e($assignment->grade->name); ?> |
            <strong>Período:</strong> <?php echo e(request('period_id')); ?>

        </p>

        
        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        
        <form method="POST" action="<?php echo e(route('teacher.dimension_comments.store')); ?>">
            <?php echo csrf_field(); ?>

            <input type="hidden" name="teacher_subject_id" value="<?php echo e($assignment->id); ?>">
            <input type="hidden" name="grade_id" value="<?php echo e($assignment->grade_id); ?>">
            <input type="hidden" name="period_id" value="<?php echo e(request('period_id')); ?>">

            <div class="card p-4">

                
                <div class="mb-3">
                    <label>📊 Saber</label>
                    <textarea name="comments[saber]" class="form-control" rows="3">
                        <?php echo e($comments['saber']->comment ?? ''); ?>

                    </textarea>
                </div>

                
                <div class="mb-3">
                    <label>🛠 Hacer</label>
                    <textarea name="comments[hacer]" class="form-control" rows="3">
                        <?php echo e($comments['hacer']->comment ?? ''); ?>

                    </textarea>
                </div>

                
                <div class="mb-3">
                    <label>🤝 Ser</label>
                    <textarea name="comments[ser]" class="form-control" rows="3">
                        <?php echo e($comments['ser']->comment ?? ''); ?>

                    </textarea>
                </div>

            </div>

            <div class="mt-3 text-end">
                <button class="btn btn-primary">
                    💾 Guardar
                </button>
            </div>

        </form>

    <?php endif; ?>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/teacher/dimension_comments/index.blade.php ENDPATH**/ ?>