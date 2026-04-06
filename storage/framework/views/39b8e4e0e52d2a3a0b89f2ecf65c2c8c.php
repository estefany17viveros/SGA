
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/subjects/index.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

<h1>Listado de Materias</h1>

<a href="<?php echo e(route('admin.subjects.create')); ?>">Crear nueva materia</a>

<br><br>

<?php if(session('success')): ?>
    <p style="color: green;"><?php echo e(session('success')); ?></p>
<?php endif; ?>

<form method="GET">
    <input type="text" name="search" placeholder="Buscar..." value="<?php echo e(request('search')); ?>">
    <button type="submit">Buscar</button>
</form>

<br>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($subject->name); ?></td>
                <td><?php echo e($subject->description); ?></td>
                <td>
                    <a href="<?php echo e(route('admin.subjects.show', $subject)); ?>">Ver</a> |
                    <a href="<?php echo e(route('admin.subjects.edit', $subject)); ?>">Editar</a> |

                    <form action="<?php echo e(route('admin.subjects.destroy', $subject)); ?>" method="POST" style="display:inline;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="3">No hay materias</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<br>

<?php echo e($subjects->links()); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/subjects/index.blade.php ENDPATH**/ ?>