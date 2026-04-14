

<?php $__env->startSection('content'); ?>
<div class="container">

    <h2 class="mb-4">📊 Registro de Ingresos al Sistema</h2>

    
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <form method="GET" class="row g-3">

                <div class="col-md-3">
                    <label class="form-label">Desde</label>
                    <input type="date" name="from" class="form-control"
                           value="<?php echo e(request('from')); ?>">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Hasta</label>
                    <input type="date" name="to" class="form-control"
                           value="<?php echo e(request('to')); ?>">
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-primary w-100">
                        🔍 Filtrar
                    </button>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <a href="<?php echo e(route('admin.login-logs.index')); ?>" class="btn btn-secondary w-100">
                        ♻ Limpiar
                    </a>
                </div>

            </form>
        </div>
    </div>

    
    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-hover table-striped align-middle text-center mb-0">

                <thead class="table-dark">
                    <tr>
                        <th>👤 Nombre</th>
                        <th>Rol</th>
                        <th>🟢 Ingreso</th>
                        <th>🔴 Salida</th>
                        <th>Estado</th>
                        <th>🌐 IP</th>
                    </tr>
                </thead>

                <tbody>

                <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>

                        
                        <td>
                            <strong><?php echo e(ucfirst($log->name)); ?></strong>
                        </td>

                        
                        <td>
                            <?php if($log->role == 'admin'): ?>
                                <span class="badge bg-success px-3 py-2">Administrador</span>
                            <?php elseif($log->role == 'teacher'): ?>
                                <span class="badge bg-primary px-3 py-2">Profesor</span>
                            <?php else: ?>
                                <span class="badge bg-secondary px-3 py-2"><?php echo e($log->role); ?></span>
                            <?php endif; ?>
                        </td>

                        
                        <td>
                            <?php if($log->login_at): ?>
                                <span class="text-success fw-semibold">
                                    <?php echo e(\Carbon\Carbon::parse($log->login_at)->format('d/m/Y')); ?>

                                </span><br>
                                <small class="text-muted">
                                    <?php echo e(\Carbon\Carbon::parse($log->login_at)->format('h:i A')); ?>

                                </small>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>

                        
                        <td>
                            <?php if($log->logout_at): ?>
                                <span class="text-danger fw-semibold">
                                    <?php echo e(\Carbon\Carbon::parse($log->logout_at)->format('d/m/Y')); ?>

                                </span><br>
                                <small class="text-muted">
                                    <?php echo e(\Carbon\Carbon::parse($log->logout_at)->format('h:i A')); ?>

                                </small>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>

                        
                        <td>
                            <?php if($log->logout_at): ?>
                                <span class="badge bg-secondary px-3 py-2">
                                    🔴 Finalizado
                                </span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark px-3 py-2">
                                    🟢 En línea
                                </span>
                            <?php endif; ?>
                        </td>

                        
                        <td>
                            <small class="text-muted"><?php echo e($log->ip_address); ?></small>
                        </td>

                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <tr>
                        <td colspan="6">
                            <p class="text-muted my-3">No hay registros aún.</p>
                        </td>
                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>
    </div>

    
    <div class="mt-3">
        <?php echo e($logs->links()); ?>

    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/login-logs/index.blade.php ENDPATH**/ ?>