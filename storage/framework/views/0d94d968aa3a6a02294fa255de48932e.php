<?php $__env->startSection('title', 'Detalle del Estudiante'); ?>

<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/admin/students/show.css'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="student-detail-container">

<div class="detail-header">
    <div class="header-left">
        <h3>📋 Detalle del Estudiante</h3>
    </div>

    <a href="<?php echo e(route('admin.students.index')); ?>" class="btn-back">
        ← Volver
    </a>
</div>


<div class="detail-card">
    <div class="card-content">

        <div class="student-layout">

            <!-- FOTO -->
            <div class="photo-section">

                <?php if($student->photo): ?>
                    <div class="photo-frame">
                        <img src="<?php echo e(asset('storage/'.$student->photo)); ?>"
                             alt="Foto de <?php echo e($student->full_name); ?>"
                             class="student-photo">
                    </div>
                <?php else: ?>
                    <div class="photo-placeholder-large">
                        👤
                        <p>Sin foto</p>
                    </div>
                <?php endif; ?>

            </div>



            <!-- INFORMACIÓN -->
            <div class="info-section">

                <div class="student-header">
                    <h4 class="student-name"><?php echo e($student->full_name); ?></h4>
                    <span class="age-badge"><?php echo e($student->age); ?> años</span>
                </div>

                <div class="divider"></div>


                <!-- INFORMACIÓN BÁSICA -->
                <div class="info-block">

                    <h5 class="block-title">Información Básica</h5>

                    <div class="info-grid">

                        <div class="info-item">
                            <span class="info-label">Nombre:</span>
                            <span class="info-value"><?php echo e($student->first_name); ?></span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Apellido:</span>
                            <span class="info-value"><?php echo e($student->last_name); ?></span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Género:</span>
                            <span class="info-value"><?php echo e(ucfirst($student->gender)); ?></span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Fecha Nacimiento:</span>
                            <span class="info-value">
                                <?php echo e($student->birth_date ? $student->birth_date->format('d/m/Y') : '-'); ?>

                            </span>
                        </div>

                    </div>

                </div>


                <div class="divider"></div>


                <!-- DOCUMENTO -->
                <div class="info-block">

                    <h5 class="block-title">Documento de Identidad</h5>

                    <div class="info-grid">

                        <div class="info-item">
                            <span class="info-label">Tipo Documento:</span>
                            <span class="info-value">
                                <?php echo e(ucfirst(str_replace('_',' ',$student->identification_type))); ?>

                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Número Documento:</span>
                            <span class="info-value">
                                <?php echo e($student->identification_number); ?>

                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Fecha Expedición:</span>
                            <span class="info-value">
                                <?php echo e($student->expedition_date ? $student->expedition_date->format('d/m/Y') : '-'); ?>

                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Departamento:</span>
                            <span class="info-value">
                                <?php echo e($student->expedition_department); ?>

                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Municipio:</span>
                            <span class="info-value">
                                <?php echo e($student->expedition_municipality); ?>

                            </span>
                        </div>

                    </div>

                </div>


                <div class="divider"></div>


                <!-- DIRECCIÓN -->
                <div class="info-block">

                    <h5 class="block-title">Residencia</h5>

                    <div class="info-grid">

                        <div class="info-item full-width">
                            <span class="info-label">Dirección:</span>
                            <span class="info-value">
                                <?php echo e($student->address); ?>

                            </span>
                        </div>

                    </div>

                </div>


                <div class="divider"></div>


                <!-- SALUD -->
                <div class="info-block">

                    <h5 class="block-title">Información de Salud</h5>

                    <div class="info-grid">

                        <div class="info-item">
                            <span class="info-label">EPS:</span>
                            <span class="info-value"><?php echo e($student->eps); ?></span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Tipo Sangre:</span>
                            <span class="info-value"><?php echo e($student->blood_type); ?></span>
                        </div>

                        <div class="info-item full-width">
                            <span class="info-label">Condiciones Médicas:</span>
                            <span class="info-value">
                                <?php echo e($student->medical_conditions ?? 'Sin condiciones médicas registradas'); ?>

                            </span>
                        </div>

                    </div>

                </div>


                <div class="divider"></div>

<div class="divider"></div>

<!-- POBLACIÓN -->
<div class="info-block">

    <h5 class="block-title">Población Especial</h5>

    <div class="info-grid">

        <div class="info-item">
            <span class="info-label">Tipo:</span>
            <span class="info-value">
                <?php if($student->population_type && $student->population_type != 'ninguno'): ?>
                    <?php echo e(ucfirst($student->population_type)); ?>

                <?php else: ?>
                    No aplica
                <?php endif; ?>
            </span>
        </div>

        <div class="info-item full-width">
            <span class="info-label">Certificado:</span>

            <?php if($student->population_certificate): ?>

                <a href="<?php echo e(asset('storage/'.$student->population_certificate)); ?>"
                   target="_blank"
                   class="btn-certificate">
                    📄 Ver Certificado
                </a>

                <a href="<?php echo e(asset('storage/'.$student->population_certificate)); ?>"
                   download
                   class="btn-certificate">
                    ⬇ Descargar
                </a>

            <?php else: ?>
                <span class="info-value">No tiene certificado</span>
            <?php endif; ?>

        </div>

    </div>

</div>


                <div class="divider"></div>

            <!-- HISTORIAL ACADÉMICO -->
            <div class="info-block">

            <h5 class="block-title">📚 Historial Académico</h5>

            <?php if($student->enrollments->count() > 0): ?>

            <table class="table table-bordered">

            <thead>
            <tr>
            <th>Año</th>
            <th>Grado</th>
            <th>Grupo</th>
            <th>Estado</th>
            </tr>
            </thead>

            <tbody>

            <?php $__currentLoopData = $student->enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <tr>

            <td>
            <?php echo e($enrollment->academicYear->year ?? '-'); ?>

            </td>

            <td>
            <?php echo e($enrollment->grade->name ?? '-'); ?>

            </td>

            <td>
            <?php echo e($enrollment->group->name ?? 'Sin grupo'); ?>

            </td>

            <td>
<?php if(
    ($enrollment->status == 'aprobado' && $enrollment->grade->level == 11)
    || $enrollment->status == 'graduado'
): ?>
    <span class="badge bg-primary">🎓 Graduado</span>

<?php elseif($enrollment->status == 'aprobado'): ?>
    <span class="badge bg-success">Aprobado</span>

<?php elseif($enrollment->status == 'reprobado'): ?>
    <span class="badge bg-danger">Reprobado</span>

<?php elseif($enrollment->status == 'matriculado'): ?>
    <span class="badge bg-warning">Matriculado</span>

<?php elseif($enrollment->status == 'retirado'): ?>
    <span class="badge bg-secondary">Retirado</span>
<?php endif; ?>
            </td>

            </tr>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </tbody>

            </table>

            <?php else: ?>

            <p>No existe historial académico.</p>

            <?php endif; ?>

            </div>
                <!-- OBSERVACIONES -->
                <div class="info-block">

                    <h5 class="block-title">Observaciones</h5>

                    <div class="observations-box">
                        <?php echo e($student->observations ?? 'No existen observaciones registradas.'); ?>

                    </div>

                </div>

                <!-- CERTIFICADO -->
                <div class="info-block">

                    <h5 class="block-title">Certificado PDF</h5>

                    <?php if($student->certificate_file): ?>

                        <a href="<?php echo e(asset('storage/'.$student->certificate_file)); ?>"
                           target="_blank"
                           class="btn-certificate">
                            📄 Ver Certificado
                        </a>

                        <a href="<?php echo e(asset('storage/'.$student->certificate_file)); ?>"
                           download
                           class="btn-certificate">
                            ⬇ Descargar Certificado
                        </a>

                    <?php else: ?>
                        <p>No se ha subido certificado.</p>
                    <?php endif; ?>

                </div>

                <div class="divider"></div>


                <!-- ACUDIENTES -->
                <div class="info-block">

                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                        <h5 class="block-title">Acudientes</h5>

                        <a href="<?php echo e(route('admin.guardians.create', $student->id)); ?>"
                           class="btn btn-success btn-sm">
                           ➕ Agregar Acudiente
                        </a>
                    </div>


                    <?php if($student->guardians->count() > 0): ?>

                    <table class="table table-bordered">

                        <thead>
                            <tr>
                                <th>Nombre</th>
                                    <th>Apellido</th>
                                <th>Parentesco</th>
                                <th>Teléfono</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php $__currentLoopData = $student->guardians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $guardian): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>

                                <td><?php echo e($guardian->first_name); ?></td>

                                <td><?php echo e($guardian->last_name); ?></td>

                                <td><?php echo e($guardian->relationship); ?></td>

                                <td><?php echo e($guardian->phone); ?></td>

                                <td>

                                    <a href="<?php echo e(route('admin.guardians.show',$guardian->id)); ?>"
                                       class="btn btn-primary btn-sm">
                                       👁️ Ver datos
                                    </a>

                                </td>

                            </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>

                    </table>

                    <?php else: ?>

                        <p>No hay acudientes registrados.</p>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>
</div>


</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/students/show.blade.php ENDPATH**/ ?>