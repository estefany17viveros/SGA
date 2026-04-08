<?php $__env->startSection('content'); ?>

<div class="container mx-auto p-6">

    <h2 class="text-2xl font-bold mb-4">📊 Gestión de Actividades y Notas</h2>

    
    <form method="GET" class="mb-6 flex gap-4 items-end">
        <div>
            <label class="block text-sm font-medium">Grado</label>
            <select name="grade_id" class="border rounded p-2">
                <option value="">Seleccione</option>
                <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($grade->id); ?>" <?php echo e(request('grade_id') == $grade->id ? 'selected' : ''); ?>>
                        <?php echo e($grade->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <button class="bg-blue-500 text-white px-4 py-2 rounded">
            Filtrar
        </button>
    </form>

    
    <?php if($students->count()): ?>

        
        <?php if(!$activities->count()): ?>
            <div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-4">
                ⚠️ No hay actividades creadas para este grado.
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('teacher.activities.storeScores')); ?>">
            <?php echo csrf_field(); ?>

            <div class="overflow-x-auto">
                <table class="w-full border border-gray-300 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border p-2">Estudiante</th>

                            
                            <?php $__empty_1 = true; $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $acts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php $__currentLoopData = $acts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th class="border p-2 text-center">
                                        <?php echo e(strtoupper($type)); ?> <br>
                                        <span class="text-xs"><?php echo e($activity->percentage); ?>%</span>
                                    </th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <th class="border p-2 text-center">
                                    Sin actividades
                                </th>
                            <?php endif; ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-t">
                                <td class="border p-2 font-semibold">
                                    <?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?>

                                </td>

                                <?php $__empty_1 = true; $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $acts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php $__currentLoopData = $acts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <td class="border p-1">
                                            <input
                                                type="number"
                                                step="0.1"
                                                min="0"
                                                max="5"
                                                name="scores[<?php echo e($student->id); ?>][<?php echo e($activity->id); ?>]"
                                                value="<?php echo e(optional($activity->scores->where('student_id', $student->id)->first())->score); ?>"
                                                class="w-full border rounded p-1 text-center"
                                            >
                                        </td>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <td class="border p-2 text-center text-gray-400">
                                        —
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            
            <?php if($activities->count()): ?>
                <div class="mt-4">
                    <button class="bg-green-500 text-white px-6 py-2 rounded">
                        💾 Guardar Notas
                    </button>
                </div>
            <?php endif; ?>

        </form>

    <?php else: ?>

        <p class="text-gray-500 mt-4">
            🔎 Selecciona un grado para ver estudiantes.
        </p>

    <?php endif; ?>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/teacher/activities/index.blade.php ENDPATH**/ ?>