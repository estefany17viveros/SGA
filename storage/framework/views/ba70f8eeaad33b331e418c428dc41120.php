<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/dashboard.css'); ?>
<?php $__env->stopPush(); ?>

<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    
    

    <div class="dashboard-wrapper">

        
        <div class="dashboard-banner">
            <div class="banner-content">
                <h2>Bienvenida, <?php echo e(Auth::user()->name); ?> 👋</h2>
                <p> Control total del sistema</p>
            </div>
        </div>

        
        <div class="stats-grid">

            <div class="stat-card stat-role">
                <span class="stat-icon">🎓</span>
                <p class="stat-label">Rol</p>
                <h3 class="stat-value"><?php echo e(ucfirst(Auth::user()->role)); ?></h3>
            </div>

            <div class="stat-card stat-total">
                <span class="stat-icon">👥</span>
                <p class="stat-label">Total Estudiantes</p>
                <h3 class="stat-value"><?php echo e($totalStudents ?? 0); ?></h3>
            </div>

            <div class="stat-card stat-adults">
                <span class="stat-icon">🔞</span>
                <p class="stat-label">Mayores de edad</p>
                <h3 class="stat-value"><?php echo e($adultStudentsCount ?? 0); ?></h3>
            </div>

            <div class="stat-card stat-minors">
                <span class="stat-icon">🧒</span>
                <p class="stat-label">Menores de edad</p>
                <h3 class="stat-value"><?php echo e(($totalStudents ?? 0) - ($adultStudentsCount ?? 0)); ?></h3>
            </div>

            <div class="stat-card stat-status">
                <span class="stat-icon">⚡</span>
                <p class="stat-label">Estado Sistema</p>
                <h3 class="stat-value">
                    <span class="stat-dot"></span>Activo
                </h3>
            </div>

        </div>

        
        <div class="table-card">

            <div class="table-card-header">
                <h2>👨‍🎓 Estudiantes mayores de edad (18+)</h2>
                <?php if(isset($adultStudents)): ?>
                    <span class="table-count-badge"><?php echo e($adultStudentsCount ?? 0); ?> registros</span>
                <?php endif; ?>
            </div>

            <?php if(isset($adultStudents) && $adultStudents->count()): ?>
                <div class="table-scroll">
                    <table class="students-table">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Edad</th>
                                <th>Estado</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__currentLoopData = $adultStudents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="col-num"><?php echo e($index + 1); ?></td>

                                    <td class="col-name">
                                        <?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?>

                                    </td>

                                    <td class="col-age">
                                        <?php echo e(\Carbon\Carbon::parse($student->birth_date)->age); ?> años
                                    </td>

                                    

                                    <td>
                                        <span class="badge-active">
                                            <span class="dot"></span>
                                            Activo
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>

                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <span class="empty-icon">🎓</span>
                    <p>No hay estudiantes mayores de edad registrados.</p>
                </div>
            <?php endif; ?>

        </div>

        
        <div class="summary-grid">

            <div class="summary-card">
                <h3>Resumen</h3>
                <p>
                    Este panel permite visualizar rápidamente el estado de los estudiantes,
                    identificar mayores de edad y tener control general del sistema académico.
                </p>
            </div>

            <div class="summary-card">
                <h3>Recomendación</h3>
                <p>
                    Se recomienda hacer seguimiento especial a estudiantes mayores de edad
                    para procesos administrativos, documentación o validaciones legales.
                </p>
            </div>

        </div>

    </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/dashboard.blade.php ENDPATH**/ ?>