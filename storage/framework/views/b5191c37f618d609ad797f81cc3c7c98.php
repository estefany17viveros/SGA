

<?php $__env->startSection('content'); ?>
<div class="container">

    <h2>📘 Mis grupos como director</h2>

    
    <?php $__empty_1 = true; $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="card p-3 mb-2">
            <strong><?php echo e($grade->name); ?></strong>

            <a href="<?php echo e(route('teacher.director.students', $grade->id)); ?>"
               class="btn btn-primary btn-sm mt-2">
                Ver estudiantes
            </a>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p>No tienes grupos asignados</p>
    <?php endif; ?>


    <hr>

    
    <h3>📚 Estudiantes de otros grados</h3>

    <div class="card p-3 mb-3">

        
        <form method="GET" class="row mb-3">

            <div class="col-md-4">
                <input type="text" name="name"
                       class="form-control"
                       placeholder="Nombre"
                       value="<?php echo e(request('name')); ?>">
            </div>

            <div class="col-md-4">
                <input type="text" name="last_name"
                       class="form-control"
                       placeholder="Apellido"
                       value="<?php echo e(request('last_name')); ?>">
            </div>

            <div class="col-md-4">
                <select name="grade_id" class="form-control">
                    <option value="">-- Todos los grados --</option>
                    <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($grade->id); ?>"
                            <?php echo e(request('grade_id') == $grade->id ? 'selected' : ''); ?>>
                            <?php echo e($grade->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="col-md-12 mt-2">
                <button class="btn btn-primary w-100">
                    🔍 Filtrar
                </button>
            </div>

        </form>

        
        <table class="table table-bordered">

            <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Grado</th>
                    <th>Documento</th>
                    <th>Acción</th>
                </tr>
            </thead>

            <tbody>

                <?php $__empty_1 = true; $__currentLoopData = $allStudents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <tr>
                        <td>
                            <?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?>

                        </td>

                        <td>
                            <?php echo e($student->enrollments->first()->grade->name ?? 'Sin grado'); ?>

                        </td>

                        <td>
                            <?php echo e($student->identification_number); ?>

                        </td>

                        <td>
                           <a href="<?php echo e(route('teacher.students.show', $student->id)); ?>"
   class="btn btn-info btn-sm">
    Ver información
</a>
                        </td>
                    </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="text-center">
                            No hay estudiantes para mostrar
                        </td>
                    </tr>
                <?php endif; ?>

            </tbody>

        </table>

        
        <div class="mt-3">
            <?php echo e($allStudents->appends(request()->all())->links()); ?>

        </div>

    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/teacher/director/index.blade.php ENDPATH**/ ?>