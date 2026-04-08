<?php $__env->startSection('content'); ?>

<div class="container">

    
    <div class="mb-4">
        <h2>📊 Registro de Notas</h2>
        <h4>
            <?php echo e($assignment->subject->name); ?> - <?php echo e($assignment->grade->name); ?>

        </h4>
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

    
    <form action="<?php echo e(route('teacher.scores.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <input type="hidden" name="teacher_subject_id" value="<?php echo e($assignment->id); ?>">

        <div class="table-responsive">
            <table class="table table-bordered table-hover">

                
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Estudiante</th>
                        <th>Saber</th>
                        <th>Hacer</th>
                        <th>Ser</th>
                        <th>Comentario</th>
                    </tr>
                </thead>

                
                <tbody>

                    <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <?php
                            $score = $scores[$student->id] ?? null;
                        ?>

                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>

                            <td>
                                <strong><?php echo e($student->full_name); ?></strong>
                            </td>

                            
                            <td>
                                <input 
                                    type="number"
                                    step="0.1"
                                    min="0"
                                    max="5"
                                    name="scores[<?php echo e($student->id); ?>][saber]"
                                    value="<?php echo e($score->saber ?? ''); ?>"
                                    class="form-control"
                                    placeholder="0.0">
                            </td>

                            
                            <td>
                                <input 
                                    type="number"
                                    step="0.1"
                                    min="0"
                                    max="5"
                                    name="scores[<?php echo e($student->id); ?>][hacer]"
                                    value="<?php echo e($score->hacer ?? ''); ?>"
                                    class="form-control"
                                    placeholder="0.0">
                            </td>

                            
                            <td>
                                <input 
                                    type="number"
                                    step="0.1"
                                    min="0"
                                    max="5"
                                    name="scores[<?php echo e($student->id); ?>][ser]"
                                    value="<?php echo e($score->ser ?? ''); ?>"
                                    class="form-control"
                                    placeholder="0.0">
                            </td>

                            
                            <td>
                                <input 
                                    type="text"
                                    name="scores[<?php echo e($student->id); ?>][comment]"
                                    value="<?php echo e($score->comment ?? ''); ?>"
                                    class="form-control"
                                    placeholder="Comentario">
                            </td>
                        </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center">
                                No hay estudiantes en este grado
                            </td>
                        </tr>
                    <?php endif; ?>

                </tbody>

            </table>
        </div>

        
        <div class="mt-3">
            <button class="btn btn-success">
                💾 Guardar Notas
            </button>
        </div>

    </form>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/teacher/scores/index.blade.php ENDPATH**/ ?>