

<?php $__env->startSection('content'); ?>

<h2>Asignación Académica</h2>
<h3><?php echo e($teacher->name); ?></h3>

<form method="POST" action="<?php echo e(route('admin.teachers.assign.save', $teacher->id)); ?>">
    <?php echo csrf_field(); ?>

    <?php
        $grades = ['6', '7', '8', '9', '10', '11'];
        $groups = ['A', 'B'];
    ?>

    <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <h4>Grado <?php echo e($grade); ?></h4>

        <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="margin-left:20px;">
                <strong>Grupo <?php echo e($group); ?></strong>

                <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php
                        $value = $subject->id . '-' . $grade . '-' . $group;
                    ?>

                    <div style="margin-left:20px;">
                        <input type="checkbox"
                               name="assignments[]"
                               value="<?php echo e($value); ?>"
                               <?php echo e(in_array($value, $assigned) ? 'checked' : ''); ?>>

                        <?php echo e($subject->name); ?>

                    </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <hr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <button>💾 Guardar</button>

</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/teacher_subjects/assign.blade.php ENDPATH**/ ?>