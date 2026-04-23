
<?php $__env->startSection('title', 'Estudiantes del grado'); ?>
<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/teacher/director/student.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">

    <h2>👨‍🎓 Estudiantes del grado: <?php echo e($grade->name ?? ''); ?></h2>

    <a href="<?php echo e(url()->previous()); ?>" class="btn btn-secondary btn-sm mb-3">
        ⬅ Volver
    </a>

    <?php if($students->isEmpty()): ?>
        <div class="alert alert-warning text-center">
            No hay estudiantes en este grado
        </div>
    <?php else: ?>
<form method="GET" class="mb-3">

    <div style="display:flex; gap:10px; flex-wrap:wrap;">

        <input type="text" name="name" placeholder="Nombre"
            value="<?php echo e(request('name')); ?>"
            class="form-control" style="max-width:200px;">

        <input type="text" name="last_name" placeholder="Apellido"
            value="<?php echo e(request('last_name')); ?>"
            class="form-control" style="max-width:200px;">

        <button type="submit" class="btn btn-primary btn-sm">
            🔍 Buscar
        </button>

        <a href="<?php echo e(route('teacher.director.students', $grade->id)); ?>"
           class="btn btn-secondary btn-sm">
            ❌ Limpiar
        </a>

    </div>

</form>
        <table class="table table-bordered table-hover">

            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Acción</th>
                </tr>
            </thead>

            <tbody>

                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($i + 1); ?></td>

                        <td>
                            <?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?>

                        </td>

                        <td>
                            <?php echo e($student->identification_number); ?>

                        </td>

                        <td>
                            <a href="<?php echo e(route('teacher.students.show', $student->id)); ?>"
                               class="btn btn-info btn-sm">
                                👁 Ver
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </tbody>

        </table>

    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/teacher/director/students.blade.php ENDPATH**/ ?>