<?php $__env->startSection('title', 'Profesores'); ?>
<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/admin/teachers/index.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

<h2>📋 Profesores</h2>

<a href="<?php echo e(route('admin.teachers.create')); ?>">Crear</a>


<?php if(session('success')): ?>
    <p style="color: green"><?php echo e(session('success')); ?></p>
<?php endif; ?>

<table border="1" cellpadding="8">

    <thead>
        <tr>
            <th>#</th>
            <th>Foto</th>
            <th>Nombre</th>
            <th>Documento</th>
            <th>Edad</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>

        <?php $__empty_1 = true; $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>

            
            <td><?php echo e($loop->iteration); ?></td>

            
            <td>
                <?php if($teacher->photo): ?>
                    <img src="<?php echo e(asset('storage/'.$teacher->photo)); ?>" width="50">
                <?php else: ?>
                    Sin foto
                <?php endif; ?>
            </td>

            
            <td><?php echo e($teacher->full_name); ?></td>

            
            <td><?php echo e($teacher->document_number); ?></td>

            
            <td><?php echo e($teacher->age); ?> años</td>

            
            <td><?php echo e($teacher->phone ?? 'N/A'); ?></td>

            
            <td><?php echo e($teacher->user->email ?? 'Sin correo'); ?></td>

            
            <td>
                <?php if($teacher->is_active): ?>
                    <span style="color: green">Activo</span>
                <?php else: ?>
                    <span style="color: red">Inactivo</span>
                <?php endif; ?>
            </td>

            
            <td>

                <a href="<?php echo e(route('admin.teachers.show', $teacher->id)); ?>">
                    👁 Ver
                </a>

                <a href="<?php echo e(route('admin.teachers.edit',$teacher->id)); ?>">
                    ✏️ Editar
                </a>
                <a href="<?php echo e(route('admin.teacher-subjects.index', $teacher->id)); ?>">
    📚 Asignación Académica
</a>

                <form method="POST" action="<?php echo e(route('admin.teachers.destroy',$teacher->id)); ?>" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button onclick="return confirm('¿Eliminar profesor?')">
                        🗑 Eliminar
                    </button>
                </form>

            </td>

        </tr>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="9">No hay profesores registrados</td>
        </tr>
        <?php endif; ?>

    </tbody>

</table>


<?php echo e($teachers->links()); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/teachers/index.blade.php ENDPATH**/ ?>