
<?php $__env->startSection('title', 'Comentarios por Dimensión'); ?>
<?php $__env->startPush('styles'); ?>
   <?php echo app('Illuminate\Foundation\Vite')(['resources/css/teacher/dimension_comments/index.css']); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

<div class="container">

    <h3>📝 Comentarios por Dimensión</h3>

    
    <form method="GET" action="<?php echo e(route('teacher.dimension_comments.index')); ?>" class="filtros-form">

        <div class="filtro-grupo">
            <label>Año</label>
            <select name="academic_year_id" onchange="this.form.submit()">
                <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($y->id); ?>" <?php echo e($yearId == $y->id ? 'selected' : ''); ?>>
                        <?php echo e($y->year); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="filtro-grupo">
            <label>Materia</label>
            <select name="teacher_subject_id" onchange="this.form.submit()">
                <option value="">-- Seleccione --</option>

                
                <option value="discipline_all"
                    <?php echo e(request('teacher_subject_id') == 'discipline_all' ? 'selected' : ''); ?>>
                    🚨 Disciplina
                </option>

                
                <?php $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($a->id !== 'discipline_all'): ?>
                        <option value="<?php echo e($a->id); ?>"
                            <?php echo e(request('teacher_subject_id') == $a->id ? 'selected' : ''); ?>>
                            <?php echo e($a->subject->name ?? ''); ?> - <?php echo e($a->grade->name ?? ''); ?>

                        </option>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="filtro-grupo">
            <label>Periodo</label>
            <select name="period_id" onchange="this.form.submit()">
                <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($p->id); ?>" <?php echo e(request('period_id') == $p->id ? 'selected' : ''); ?>>
                        <?php echo e($p->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <button type="submit" class="btn-filtrar">🔍 Filtrar</button>

    </form>

    
    <?php if($assignment && request('period_id')): ?>

        <form method="POST" action="<?php echo e(route('teacher.dimension_comments.store')); ?>" class="form-comentarios">
            <?php echo csrf_field(); ?>

            <input type="hidden" name="teacher_subject_id" value="<?php echo e($assignment->id); ?>">
            <?php if(!$isDiscipline): ?>
                <input type="hidden" name="grade_id" value="<?php echo e($assignment->grade_id); ?>">
            <?php endif; ?>
            <input type="hidden" name="period_id" value="<?php echo e(request('period_id')); ?>">
            <input type="hidden" name="academic_year_id" value="<?php echo e($yearId); ?>">

            
            <?php if($isDiscipline): ?>

                <div class="dimensiones-grid disciplina-solo">
                    <div class="dimension-card disciplina">
                        <div class="dimension-header">
                            <span class="dimension-icon">🚨</span>
                            <span class="dimension-title">Disciplina</span>
                        </div>
                        <textarea name="comments[disciplina]" class="form-control" rows="8"
                            placeholder="Escribe el comentario de disciplina..."><?php echo e($comments['disciplina']->comment ?? ''); ?></textarea>
                    </div>
                </div>

            
            <?php else: ?>

                <div class="dimensiones-grid">

                    <div class="dimension-card saber">
                        <div class="dimension-header">
                            <span class="dimension-icon">📘</span>
                            <span class="dimension-title">Saber</span>
                        </div>
                        <textarea name="comments[saber]" class="form-control" rows="7"
                            placeholder="Comentario sobre el saber..."><?php echo e(trim($comments['saber']->comment ?? '')); ?></textarea>
                    </div>

                    <div class="dimension-card hacer">
                        <div class="dimension-header">
                            <span class="dimension-icon">🛠</span>
                            <span class="dimension-title">Hacer</span>
                        </div>
                        <textarea name="comments[hacer]" class="form-control" rows="7"
                            placeholder="Comentario sobre el hacer..."><?php echo e(trim($comments['hacer']->comment ?? '')); ?></textarea>
                    </div>

                    <div class="dimension-card ser">
                        <div class="dimension-header">
                            <span class="dimension-icon">🤝</span>
                            <span class="dimension-title">Ser</span>
                        </div>
                        <textarea name="comments[ser]" class="form-control" rows="7"
                            placeholder="Comentario sobre el ser..."><?php echo e(trim($comments['ser']->comment ?? '')); ?></textarea>
                    </div>

                </div>

            <?php endif; ?>

            <div class="form-footer">
                <button type="submit" class="btn-guardar">💾 Guardar Comentarios</button>
            </div>

        </form>

    <?php endif; ?>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/teacher/dimension_comments/index.blade.php ENDPATH**/ ?>