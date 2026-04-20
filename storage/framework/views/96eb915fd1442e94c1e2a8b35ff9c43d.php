

<?php $__env->startSection('title', 'Estudiantes Retirados'); ?>
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/admin/enrollments/retired.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

<div class="container">

<h2>Estudiantes Retirados</h2>


<?php if(session('success')): ?>
    <div class="alert alert-success">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>


<form method="GET" class="row mb-3">

    <div class="col-md-4">
        <input type="text" name="last_name" class="form-control"
            placeholder="Buscar por apellido"
            value="<?php echo e(request('last_name')); ?>">
    </div>

    <div class="col-md-4">
        <select name="year" class="form-control">
            <option value="">Todos los años</option>

            <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($year->year); ?>"
                    <?php echo e(request('year') == $year->year ? 'selected' : ''); ?>>
                    <?php echo e($year->year); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <div class="col-md-4">
        <button class="btn btn-primary">Filtrar</button>
        <a href="<?php echo e(route('admin.enrollments.retired')); ?>" class="btn btn-secondary">
            Limpiar
        </a>
    </div>

</form>


<table class="table table-bordered">

    <thead>
        <tr>
            <th>Estudiante</th>
            <th>Año</th>
            <th>Grado</th>
            <th>Grupo</th>
            <th>Estado</th>
        </tr>
    </thead>

    <tbody>

        <?php $__empty_1 = true; $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

            <tr>

                <td>
                    <?php echo e($enrollment->student->first_name); ?>

                    <?php echo e($enrollment->student->last_name); ?>

                </td>

                <td>
                    <?php echo e($enrollment->academicYear->year); ?>

                </td>

                <td>
                    <?php echo e($enrollment->grade->name); ?>

                </td>

                <td>
                    <?php echo e($enrollment->group->name ?? 'Sin grupo'); ?>

                </td>

                <td>
                    <span class="badge bg-danger">
                        🚫 Retirado
                    </span>
                </td>

            </tr>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

            <tr>
                <td colspan="5">No hay estudiantes retirados</td>
            </tr>

        <?php endif; ?>

    </tbody>

</table>


<div class="mt-3">
    <?php echo e($enrollments->links()); ?>

</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/enrollments/retired.blade.php ENDPATH**/ ?>