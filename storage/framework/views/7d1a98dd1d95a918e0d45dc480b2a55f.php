<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boletines Masivos</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
        }

        .page {
            page-break-after: always;
            padding: 0;
        }

        .page:last-child {
            page-break-after: auto;
        }
    </style>
</head>
<body>

<?php $__currentLoopData = $boletines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <?php
        $student   = $data['student'];
        $scores    = $data['scores'];
        $allScores = $data['allScores'];
        $puesto    = $data['puesto'];
        $grade     = $data['grade'];
    ?>

    <div class="page">

        <?php echo $__env->make('admin.boletin.show', [
            'student' => $student,
            'scores' => $scores,
            'allScores' => $allScores,
            'puesto' => $puesto,
            'grade' => $grade,
            'period' => $period,
            'yearLectivo' => $yearLectivo,
            'logoBase64' => $logoBase64,
            'isPdf' => true
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    </div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</body>
</html><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/boletin/masivo.blade.php ENDPATH**/ ?>