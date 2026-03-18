

<?php $__env->startSection('title', 'Gestión de Matrículas'); ?>

<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/enrollments/index.css'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="container">

<h2>Gestión de Matrículas</h2>


<a href="<?php echo e(route('admin.enrollments.create')); ?>" class="btn btn-primary mb-3">
    Nueva Matrícula
</a>


<form action="<?php echo e(route('admin.enrollments.approveAll')); ?>" method="POST" class="mb-3">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <button class="btn btn-success"
        onclick="return confirm('¿Seguro que deseas aprobar todos los estudiantes?')">
        ✅ Aprobar todos
    </button>
</form>


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


<form method="GET" class="mb-3">
    <select name="grade_id" onchange="this.form.submit()" class="form-control">

        <option value="">Todos los grados</option>

        <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($grade->id); ?>"
                <?php echo e(request('grade_id') == $grade->id ? 'selected' : ''); ?>>
                Grado <?php echo e($grade->name); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </select>
</form>


<table class="table table-bordered">

    <thead>
        <tr>
            <th>Estudiante</th>
            <th>Año</th>
            <th>Grado</th>
            <th>Grupo</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>

        <?php $__empty_1 = true; $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

            <tr>

                <td>
                    <?php echo e($enrollment->student->first_name ?? ''); ?>

                    <?php echo e($enrollment->student->last_name ?? ''); ?>

                </td>

                <td>
                    <?php echo e($enrollment->academicYear->year ?? ''); ?>

                </td>

                <td>
                    <?php echo e($enrollment->grade->name ?? ''); ?>

                </td>

                <td>
                    <?php echo e($enrollment->group->name ?? 'Sin grupo'); ?>

                </td>

                
                <td>
                    <?php if($enrollment->status == 'graduado'): ?>

                        <span class="badge bg-primary">
                            🎓 Graduado
                        </span>

                    <?php else: ?>

                        <form action="<?php echo e(route('admin.enrollments.updateStatus',$enrollment->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <select name="status" onchange="this.form.submit()" class="form-control">

                                <option value="matriculado" <?php echo e($enrollment->status=='matriculado'?'selected':''); ?>>
                                    Matriculado
                                </option>

                                <option value="aprobado" <?php echo e($enrollment->status=='aprobado'?'selected':''); ?>>
                                    Aprobado
                                </option>

                                <option value="reprobado" <?php echo e($enrollment->status=='reprobado'?'selected':''); ?>>
                                    Reprobado
                                </option>

                                <option value="retirado" <?php echo e($enrollment->status=='retirado'?'selected':''); ?>>
                                    Retirado
                                </option>

                            </select>
                        </form>

                    <?php endif; ?>
                </td>

                
                <td>

                    <a href="<?php echo e(route('admin.enrollments.show',$enrollment->id)); ?>" class="btn btn-info btn-sm">
                        Ver
                    </a>

                    <?php if($enrollment->status != 'graduado'): ?>

                        <a href="<?php echo e(route('admin.enrollments.edit',$enrollment->id)); ?>" class="btn btn-warning btn-sm">
                            Editar
                        </a>

                        <form action="<?php echo e(route('admin.enrollments.destroy',$enrollment->id)); ?>" method="POST" style="display:inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>

                            <button class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Seguro que deseas eliminar esta matrícula?')">
                                Eliminar
                            </button>
                        </form>

                    <?php else: ?>

                        <span class="text-muted">🔒 Bloqueado</span>

                    <?php endif; ?>

                </td>

            </tr>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

            <tr>
                <td colspan="6">No hay matrículas registradas</td>
            </tr>

        <?php endif; ?>

    </tbody>

</table>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/enrollments/index.blade.php ENDPATH**/ ?>