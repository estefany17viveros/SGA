

<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/teacher/students.css'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="container">

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>👨‍🎓 Estudiantes</h2>

    <a href="<?php echo e(route('teacher.scores.index', $teacher_subject_id)); ?>" class="btn btn-primary">
        📊 Gestionar Notas
    </a>
</div>

<a href="<?php echo e(route('teacher.dashboard')); ?>">⬅ Volver al inicio</a>

<?php
    use App\Models\AcademicYear;
    use App\Models\Period;

    $year = AcademicYear::where('status', 'activo')->first();

    // ✅ SIEMPRE colección
    $periods = collect();

    if ($year) {
        $periods = Period::where('academic_year_id', $year->id)
            ->orderBy('number')
            ->get(); // 🔥 SIN toArray()
    }

    // 🔥 ORDENAR POR PROMEDIO
    $studentsSorted = $students->sortByDesc(function($student) use ($teacher_subject_id, $periods) {

        $total = 0;
        $count = 0;

        foreach ($periods as $period) {
            $score = $student->scores
                ->where('teacher_subject_id', $teacher_subject_id)
                ->where('period_id', $period->id) // ✅ correcto
                ->first();

            if ($score && $score->total !== null) {
                $total += $score->total;
                $count++;
            }
        }

        return $count > 0 
            ? floor(($total / $count) * 100) / 100 
            : 0;
    })->values();
?>

<div class="table-responsive mt-3">
    <table class="table table-bordered">

        
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nombre</th>

                <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th>P<?php echo e($period->number); ?></th>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <th>Promedio Acumulado</th>
                <th>Puesto</th>
            </tr>
        </thead>

        <tbody>

            <?php $__empty_1 = true; $__currentLoopData = $studentsSorted; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <?php
                    $student->loadMissing('scores');

                    $totalFinal = 0;
                    $count = 0;
                    $periodTotals = [];

                    foreach ($periods as $period) {

                        $score = $student->scores
                            ->where('teacher_subject_id', $teacher_subject_id)
                            ->where('period_id', $period->id)
                            ->first();

                        $value = $score->total ?? null;

                        if (!is_null($value)) {
                            $totalFinal += $value;
                            $count++;
                        }

                        // ✅ usar ID como clave
                        $periodTotals[$period->id] = $value;
                    }

                    $averageFinal = $count > 0 
                        ? floor(($totalFinal / $count) * 100) / 100 
                        : 0;

                    // 🔥 POSICIÓN
                    $position = 1;

                    foreach ($studentsSorted as $index => $s) {

                        $sTotal = 0;
                        $sCount = 0;

                        foreach ($periods as $p) {
                            $sc = $s->scores
                                ->where('teacher_subject_id', $teacher_subject_id)
                                ->where('period_id', $p->id)
                                ->first();

                            if ($sc && $sc->total !== null) {
                                $sTotal += $sc->total;
                                $sCount++;
                            }
                        }

                        $sAvg = $sCount > 0 
                            ? floor(($sTotal / $sCount) * 100) / 100 
                            : 0;

                        if ($index > 0) {
                            $prev = $studentsSorted[$index - 1];

                            $prevTotal = 0;
                            $prevCount = 0;

                            foreach ($periods as $p) {
                                $psc = $prev->scores
                                    ->where('teacher_subject_id', $teacher_subject_id)
                                    ->where('period_id', $p->id)
                                    ->first();

                                if ($psc && $psc->total !== null) {
                                    $prevTotal += $psc->total;
                                    $prevCount++;
                                }
                            }

                            $prevAvg = $prevCount > 0 
                                ? floor(($prevTotal / $prevCount) * 100) / 100 
                                : 0;

                            if ($sAvg != $prevAvg) {
                                $position = $index + 1;
                            }
                        }

                        if ($s->id == $student->id) {
                            break;
                        }
                    }
                ?>

                <tr>
                    <td><?php echo e($loop->iteration); ?></td>

                    <td><?php echo e($student->full_name); ?></td>

                    
                    <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td class="text-center">
                            <span class="badge bg-secondary">
                                <?php echo e(isset($periodTotals[$period->id]) 
                                    ? number_format(floor($periodTotals[$period->id] * 100) / 100, 2, '.', '') 
                                    : '-'); ?>

                            </span>
                        </td>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <td class="text-center">
                        <span class="badge bg-success">
                            <?php echo e(number_format($averageFinal, 2, '.', '')); ?>

                        </span>
                    </td>

                    <td class="text-center">
                        <span class="badge bg-warning text-dark">
                            <?php echo e($position); ?>

                        </span>
                    </td>
                </tr>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <tr>
                    <td colspan="<?php echo e($periods->count() + 4); ?>" class="text-center">
                        No hay estudiantes
                    </td>
                </tr>

            <?php endif; ?>

        </tbody>

    </table>
</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/teacher/students.blade.php ENDPATH**/ ?>