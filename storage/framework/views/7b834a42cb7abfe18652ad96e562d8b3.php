

<?php $__env->startSection('title', 'Estudiantes Egresados'); ?>
<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/admin/enrollments/graduated.css']); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

<div class="container">

    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>🎓 Estudiantes Egresados</h2>

        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.enrollments.create_graduate')); ?>" class="btn btn-success">
                ➕ Nuevo Egresado
            </a>

            <a href="<?php echo e(route('admin.enrollments.index')); ?>" class="btn btn-secondary">
                ← Volver
            </a>
        </div>
    </div>

    
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

    
    <div class="card mb-3 p-3">
        <form method="GET">

            <div class="row">

                
                <div class="col-md-4">
                    <label>Buscar por apellido</label>
                    <input type="text"
                           name="last_name"
                           class="form-control"
                           value="<?php echo e(request('last_name')); ?>"
                           placeholder="Ej: Pérez">
                </div>

                
                <div class="col-md-4">
                    <label>Filtrar por año</label>
                    <select name="year" class="form-control">

                        <option value="">Todos</option>

                        <?php $__currentLoopData = $years ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($year); ?>"
                                <?php echo e(request('year') == $year ? 'selected' : ''); ?>>
                                <?php echo e($year); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </select>
                </div>

                
                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button class="btn btn-primary">🔍 Buscar</button>

                    <a href="<?php echo e(route('admin.enrollments.graduated')); ?>" class="btn btn-secondary">
                        Limpiar
                    </a>
                </div>

            </div>

        </form>
    </div>

    
    <div class="card">
        <div class="table-responsive">

            <table class="table table-hover table-bordered align-middle mb-0">

                <thead class="table-dark text-center">
                    <tr>
                        <th>Estudiante</th>
                        <th>Año de Graduación</th>
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

                            
                            <td class="text-center">
                                <?php echo e($enrollment->graduation_year ?? 'Sin año'); ?>

                            </td>

                            
                            <td class="text-center">
                                <span class="badge bg-success">
                                    🎓 Egresado
                                </span>
                            </td>

                            
                            <td class="text-center">

                                <a href="<?php echo e(route('admin.students.show', $enrollment->student_id)); ?>"
                                   class="btn btn-info btn-sm">
                                    👁 Ver estudiante
                                </a>

                            </td>

                        </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <tr>
                            <td colspan="4" class="text-center">
                                No hay estudiantes egresados registrados
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

            
            <div class="mt-3 px-3">
                <?php echo e($enrollments->links()); ?>

            </div>

        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/enrollments/graduated.blade.php ENDPATH**/ ?>