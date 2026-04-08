<div class="mt-10">

    <h3 class="text-lg font-bold mb-3"><?php echo e($label); ?></h3>

    <form action="<?php echo e(route('teacher.scores.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <input type="hidden" name="type" value="<?php echo e($type); ?>">

        <table class="w-full border text-sm">

            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">Estudiante</th>

                    <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th class="border p-2 text-center">
                            <?php echo e($activity->description); ?>

                            <br>
                            <small><?php echo e($activity->percentage); ?>%</small>
                        </th>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
            </thead>

            <tbody>

                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="border p-2 font-semibold">
                        <?php echo e($student->full_name); ?>

                    </td>

                    <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <?php
                            $score = $activity->scores
                                ->where('student_id',$student->id)
                                ->first();
                        ?>

                        <td class="border p-2 text-center">
                            <input type="number"
                                step="0.01"
                                min="0" max="5"
                                name="scores[<?php echo e($student->id); ?>][<?php echo e($activity->id); ?>]"
                                value="<?php echo e($score->score ?? ''); ?>"
                                class="w-20 border rounded text-center">
                        </td>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </tbody>
        </table>

        <div class="mt-4">
            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                💾 Guardar notas <?php echo e(strtoupper($type)); ?>

            </button>
        </div>

    </form>

</div><?php /**PATH C:\xampp\htdocs\SGA\resources\views/teacher/activities/partials/dimension.blade.php ENDPATH**/ ?>