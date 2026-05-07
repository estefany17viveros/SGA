<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boletines Masivos</title>

    <style>
    * { box-sizing: border-box !important; margin: 0; padding: 0; }

    html, body {
        font-family: 'DejaVu Sans', sans-serif;
        font-size: 7px;
        color: #111827;
        background: #ffffff;
    }

    .pagina-boletin {
        page-break-after: always;
    }

    .pagina-boletin:last-child {
        page-break-after: auto;
    }

    .bol-wrap {
        width: 100%;
        background: #fff;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .franja-top  {
        display: block;
        height: 3px;
        background: #1a3a6b;
        font-size: 0;
        line-height: 0;
    }

    .franja-gold {
        display: block;
        height: 1.5px;
        background: #c89b3c;
        font-size: 0;
        line-height: 0;
    }

    .franja-bot  {
        display: block;
        height: 3px;
        background: #1a3a6b;
        font-size: 0;
        line-height: 0;
    }

    /* ─────────────────────────────
       MARCA DE AGUA
    ───────────────────────────── */
    .marca-agua {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        width: 200px;
        height: 200px;
        object-fit: contain;
        opacity: 0.04;
        pointer-events: none;
        z-index: 0;
    }

    /* ─────────────────────────────
       CABECERA
    ───────────────────────────── */
    .cab-table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-bottom: 0.5px solid #d6e4f7;
    }

    .cab-table td {
        vertical-align: middle;
        padding: 4px 5px;
    }

    .cab-logo-td {
        width: 60px;
        padding-left: 7px !important;
        vertical-align: middle !important;
    }

    .cab-inst-td {
        padding-left: 6px !important;
        vertical-align: middle !important;
    }

    .cab-meta-td {
        width: 108px;
        text-align: right;
        padding-right: 7px !important;
        vertical-align: top !important;
        padding-top: 4px !important;
    }

    .logo-fb {
        font-size: 9px;
        font-weight: 700;
        color: #1a3a6b;
        line-height: 56px;
        display: block;
        text-align: center;
    }

    .inst-nom {
        font-size: 8.5px;
        font-weight: 700;
        color: #1a3a6b;
        display: block;
        margin-bottom: 1px;
        line-height: 1.2;
    }

    .inst-sub {
        font-size: 5.5px;
        color: #6b7280;
        line-height: 1.6;
        display: block;
    }

    .bol-badge {
        display: inline-block;
        background: #1a3a6b;
        color: #fff;
        font-size: 6px;
        font-weight: 700;
        padding: 1px 5px;
        border-radius: 3px;
        margin-bottom: 2px;
    }

    .meta-fila {
        font-size: 6px;
        color: #374151;
        line-height: 1.75;
        display: block;
    }

    .meta-fila strong {
        color: #1a3a6b;
        font-weight: 600;
    }

    /* ─────────────────────────────
       ESTUDIANTE
    ───────────────────────────── */
    .est-wrap {
        padding: 4px 8px 0;
    }

    .est-table {
        width: 100%;
        border-collapse: collapse;
        background: #1a3a6b;
        border-radius: 4px;
        overflow: hidden;
    }

    .est-table td {
        vertical-align: middle;
        padding: 5px 7px;
    }

    .est-sep {
        width: 0.5px;
        border-left: 0.5px solid rgba(255,255,255,0.2);
        padding: 0 !important;
    }

    .est-dato-td {
        width: 70px;
        text-align: center;
    }

    .est-lbl {
        font-size: 5px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: .6px;
        color: rgba(255,255,255,0.55);
        display: block;
        margin-bottom: 1px;
    }

    .est-nom {
        font-size: 9.5px;
        font-weight: 700;
        color: #fff;
        line-height: 1.1;
        display: block;
    }

    .est-dlbl {
        font-size: 5px;
        text-transform: uppercase;
        letter-spacing: .3px;
        color: rgba(255,255,255,0.5);
        display: block;
        margin-bottom: 1px;
    }

    .est-dval {
        font-size: 8px;
        font-weight: 600;
        color: #fff;
        display: block;
    }

    /* ─────────────────────────────
       KPIs
    ───────────────────────────── */
    .kpis-wrap {
        padding: 5px 8px;
    }

    .kpis-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 3px 0;
    }

    .kpi-td {
        width: 25%;
        vertical-align: top;
    }

    .kpi-box {
        background: #f8fafc;
        border: 0.5px solid #d1d5db;
        border-radius: 4px;
        text-align: center;
        padding: 3px 3px 4px;
        overflow: hidden;
    }

    .kpi-bar {
        display: block;
        height: 2px;
        background: #2d5da8;
        margin: -3px -3px 3px -3px;
        border-radius: 2px 2px 0 0;
    }

    .kpi-lbl {
        font-size: 5px;
        text-transform: uppercase;
        letter-spacing: .4px;
        color: #6b7280;
        display: block;
        margin-bottom: 1px;
    }

    .kpi-val {
        font-size: 12px;
        font-weight: 700;
        color: #1a3a6b;
        line-height: 1;
        display: block;
    }

    .kpi-sub {
        font-size: 5px;
        color: #9ca3af;
        display: block;
        margin-top: 1px;
    }

    /* ─────────────────────────────
       MATERIAS
    ───────────────────────────── */
    .mats-wrap {
        padding: 0 8px 7px;
    }

    .sec-hdr-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 4px;
    }

    .sec-hdr-td-t {
        white-space: nowrap;
        padding: 0 5px;
        font-size: 5.5px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #1a3a6b;
    }

    .mat-card {
        border: 0.5px solid #d1d5db;
        border-radius: 4px;
        overflow: hidden;
        margin-bottom: 3px;
        background: #fff;
        page-break-inside: avoid;
    }

    .mat-top {
        width: 100%;
        border-collapse: collapse;
        background: #eef4fc;
        border-bottom: 0.5px solid #d6e4f7;
    }

    .mat-top td {
        vertical-align: middle;
    }

    .mat-izq-td {
        padding: 4px 7px;
    }

    .mat-nom {
        font-size: 7.5px;
        font-weight: 700;
        color: #1a3a6b;
        display: block;
        margin-bottom: 1px;
        line-height: 1.2;
    }

    .mat-doc {
        font-size: 5.5px;
        color: #6b7280;
        font-style: italic;
        display: block;
        margin-bottom: 2px;
    }

    .hist-pill {
        display: inline-block;
        background: #d6e4f7;
        color: #1a3a6b;
        padding: 1px 4px;
        border-radius: 20px;
        font-size: 5px;
        font-weight: 500;
        margin-right: 2px;
    }

    .mat-der-td {
        width: 58px;
        border-left: 0.5px solid #d6e4f7;
        text-align: center;
        padding: 3px 4px;
        vertical-align: middle;
    }

    .nvl-badge {
        display: block;
        font-size: 5px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 1px 0;
        border-radius: 20px;
        margin-bottom: 2px;
        text-align: center;
    }

    .nvl-bajo {
        background: #fdf0f0;
        color: #9b1c1c;
        border: 0.5px solid #fca5a5;
    }

    .nvl-basico {
        background: #fef3e2;
        color: #b45309;
        border: 0.5px solid #fcd34d;
    }

    .nvl-alto {
        background: #eef4fc;
        color: #1a3a6b;
        border: 0.5px solid #d6e4f7;
    }

    .nvl-superior {
        background: #e6f4ec;
        color: #1e6b45;
        border: 0.5px solid #6ee7b7;
    }

    .mat-nota-g {
        font-size: 17px;
        font-weight: 700;
        color: #111827;
        line-height: 1;
        display: block;
    }

    .mat-nota-lbl {
        font-size: 5px;
        text-transform: uppercase;
        letter-spacing: .3px;
        color: #6b7280;
    }

    /* ─────────────────────────────
       DIMENSIONES
    ───────────────────────────── */
    .dims-table {
        width: 100%;
        border-collapse: collapse;
        border-bottom: 0.5px dashed #e5e7eb;
    }

    .dim-td {
        padding: 3px 7px;
        width: 33.33%;
        border-right: 0.5px solid #e5e7eb;
        vertical-align: middle;
    }

    .dim-td:last-child {
        border-right: none;
    }

    .dim-inner {
        border-collapse: collapse;
    }

    .dim-inner td {
        vertical-align: middle;
    }

    .dim-ico {
        width: 13px;
        height: 13px;
        border-radius: 3px;
        font-size: 6.5px;
        font-weight: 700;
        text-align: center;
        line-height: 13px;
        display: block;
    }

    .d-s {
        background: #dbeafe;
        color: #1e40af;
    }

    .d-h {
        background: #d1fae5;
        color: #065f46;
    }

    .d-p {
        background: #ede9fe;
        color: #4c1d95;
    }

    .dim-lbl-td {
        padding-left: 3px;
    }

    .dim-nm {
        font-size: 5px;
        text-transform: uppercase;
        letter-spacing: .3px;
        color: #6b7280;
        font-weight: 500;
        display: block;
    }

    .dim-nt {
        font-size: 9px;
        font-weight: 700;
        color: #111827;
        line-height: 1.1;
        display: block;
    }

    /* ─────────────────────────────
       COMENTARIOS
    ───────────────────────────── */
    .coms-wrap {
        padding: 3px 7px 4px;
        background: #fafbfc;
    }

    .com-table {
        width: 100%;
        border-collapse: collapse;
        border-top: 0.5px solid #f3f4f6;
    }

    .com-table:first-child {
        border-top: none;
    }

    .com-table td {
        font-size: 6px;
        color: #374151;
        padding: 1px 0;
        line-height: 1.4;
        vertical-align: top;
    }

    .com-tag {
        display: inline-block;
        font-size: 5px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 1px 3px;
        border-radius: 3px;
        white-space: nowrap;
    }

    .tag-saber {
        background: #dbeafe;
        color: #1e40af;
    }

    .tag-hacer {
        background: #d1fae5;
        color: #065f46;
    }

    .tag-ser {
        background: #ede9fe;
        color: #4c1d95;
    }

    .com-pre {
        color: #2d5da8;
        font-style: italic;
        font-weight: 500;
        white-space: nowrap;
        padding: 0 2px;
    }

    .com-vacio {
        font-size: 5.5px;
        color: #9ca3af;
        font-style: italic;
    }

    /* ─────────────────────────────
       PIE
    ───────────────────────────── */
    .pie-wrap {
        padding: 0 8px 8px;
    }

    .escala-box {
        border: 0.5px solid #d1d5db;
        border-radius: 4px;
        padding: 3px 7px;
        background: #f9fafb;
        margin-bottom: 6px;
    }

    .escala-t {
        font-size: 5px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #6b7280;
        margin-bottom: 3px;
        display: block;
    }

    .escala-table {
        border-collapse: collapse;
    }

    .escala-dot {
        width: 7px;
        height: 7px;
        border-radius: 2px;
        display: inline-block;
        margin-right: 3px;
        vertical-align: middle;
    }

    .escala-txt {
        font-size: 6px;
        color: #374151;
        white-space: nowrap;
    }

    .firmas-table {
        width: 100%;
        border-collapse: collapse;
    }

    .firma-td {
        width: 33.33%;
        text-align: center;
        padding: 0 5px;
    }

    .firma-linea {
        height: 20px;
        border-bottom: 0.5px solid #111827;
        display: block;
        margin-bottom: 2px;
    }

    .firma-nom {
        font-size: 6px;
        font-weight: 600;
        color: #111827;
        display: block;
    }

    .firma-car {
        font-size: 5px;
        color: #6b7280;
        display: block;
    }

    /* ─────────────────────────────
       NOTA PIE
    ───────────────────────────── */
    .nota-pie {
        background: #1a3a6b;
        padding: 3px 8px;
    }

    .nota-pie-table {
        width: 100%;
        border-collapse: collapse;
    }

    .nota-pie-table td {
        font-size: 5px;
        color: rgba(255,255,255,0.65);
        padding: 0;
        vertical-align: middle;
    }

    .nota-pie-right {
        text-align: right;
    }

    /* ─────────────────────────────
       HORAS
    ───────────────────────────── */
    .mat-horas {
        font-size: 9px !important;
        font-weight: 600 !important;
        color: #3b5ea6 !important;
        background: #e8f0fb;
        border-radius: 3px;
        padding: 1px 4px;
        letter-spacing: 0.01em;
    }

    /* ─────────────────────────────
       DISCIPLINA
    ───────────────────────────── */
    .mat-card-disciplina {
        border-left: 3px solid #d97706 !important;
        background: #fffbeb !important;
    }

    @page {
        size: A4;
        margin: 0;
    }

    @media print {
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .mat-card {
            page-break-inside: avoid;
        }
    }
    </style>
</head>

<body>

<?php

$isLastPeriod = \App\Models\Period::where('academic_year_id', $period->academic_year_id)
    ->orderBy('id')
    ->pluck('id')
    ->last() == $period->id;

if (!function_exists('truncar1')) {

    function truncar1($val)
    {
        return number_format(
            floor((float)$val * 10) / 10,
            1,
            '.',
            ''
        );
    }
}

?>

<?php $__currentLoopData = $boletines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<?php

$student           = $data['student'];
$scores            = $data['scores'];
$allScores         = $data['allScores'];
$puesto            = $data['puesto'];
$grade             = $data['grade'];
$disciplineComment = $data['disciplineComment'];
$directorName      = $data['directorName'];
$promedioAcumulado = $data['promedioAcumulado'];


$notaDisciplina = (float)($data['disciplineNote'] ?? 0);

$discPrefijo = match(true) {
    $notaDisciplina >= 4.6 => 'Siempre',
    $notaDisciplina >= 4.0 => 'Casi siempre',
    $notaDisciplina >= 3.0 => 'Algunas veces',
    default                => 'Con dificultad',
};

$discNivelClass = match(true) {
    $notaDisciplina >= 4.6 => 'nvl-superior',
    $notaDisciplina >= 4.0 => 'nvl-alto',
    $notaDisciplina >= 3.0 => 'nvl-basico',
    default                => 'nvl-bajo',
};

$discNivelNombre = match(true) {
    $notaDisciplina >= 4.6 => 'Superior',
    $notaDisciplina >= 4.0 => 'Alto',
    $notaDisciplina >= 3.0 => 'Básico',
    default                => 'Bajo',
};

?>

<div class="pagina-boletin">

    <?php if(!empty($logoBase64)): ?>
        <img class="marca-agua" src="<?php echo e($logoBase64); ?>" alt="">
    <?php endif; ?>

    <div class="bol-wrap">

        <span class="franja-top"></span>
        <span class="franja-gold"></span>

        
        <table class="cab-table">
            <tr>

                <td class="cab-logo-td">

                    <?php if(!empty($logoBase64)): ?>

                        <img
                            src="<?php echo e($logoBase64); ?>"
                            alt="Logo"
                            style="
                                width:55px;
                                height:55px;
                                object-fit:contain;
                                display:block;
                                background:transparent;
                            "
                        >

                    <?php else: ?>

                        <span class="logo-fb">ITAF</span>

                    <?php endif; ?>

                </td>

                <td class="cab-inst-td">

                    <span class="inst-nom">
                        Instituto Técnico Agropecuario y Forestal
                    </span>

                    <span class="inst-sub">
                        NIT: 800.032.991-3 · DANE: 319256002686 · Res. 2396 – Nov 27/2003
                        <br>
                        Vda. Villa al Mar Fondas · El Tambo, Cauca · Cel: 314 679 9431
                    </span>

                </td>

                <td class="cab-meta-td">

                    <span class="bol-badge">
                        Boletín Académico
                    </span>

                    <br>

                    <span class="meta-fila">
                        Año lectivo:
                        <strong><?php echo e($yearLectivo ?? '2025'); ?></strong>
                    </span>

                    <span class="meta-fila">
                        Calendario:
                        <strong>A</strong>
                    </span>

                    <span class="meta-fila">
                        Trimestre:
                        <strong><?php echo e($period->name); ?></strong>
                    </span>

                    <span class="meta-fila">
                        Fecha:
                        <strong><?php echo e(now()->format('d/m/Y')); ?></strong>
                    </span>

                </td>

            </tr>
        </table>

        
        <div class="est-wrap">

            <table class="est-table">
                <tr>

                    <td style="width:54px;text-align:center;">

                        <table
                            style="
                                width:40px;
                                height:40px;
                                background:rgba(255,255,255,0.15);
                                border-radius:50%;
                                margin:auto;
                            "
                        >
                            <tr>
                                <td style="text-align:center;vertical-align:middle;">

                                    <svg viewBox="0 0 24 24" width="20" height="20"
                                         style="fill:rgba(255,255,255,0.9);">

                                        <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>

                                    </svg>

                                </td>
                            </tr>
                        </table>

                    </td>

                    <td style="vertical-align:middle;padding:11px 8px;">

                        <span class="est-lbl">Nombre del Estudiante</span>

                        <span class="est-nom">
                            <?php echo e(strtoupper($student->full_name)); ?>

                        </span>

                    </td>

                    <td class="est-sep"></td>

                    <td class="est-dato-td">

                        <span class="est-dlbl">Identificación</span>

                        <span class="est-dval">
                            <?php echo e($student->identification_number); ?>

                        </span>

                    </td>

                    <td class="est-sep"></td>

                    <td class="est-dato-td">

                        <span class="est-dlbl">Grado</span>

                        <span class="est-dval">
                            <?php echo e($grade); ?>

                        </span>

                    </td>

                </tr>
            </table>

        </div>

        
        <div class="kpis-wrap">

            <table class="kpis-table">
                <tr>

                    <td class="kpi-td">
                        <div class="kpi-box">

                            <span class="kpi-bar"></span>

                            <span class="kpi-lbl">
                                Promedio Acumulado
                            </span>

                            <span class="kpi-val">
                                <?php echo e(truncar1($promedioAcumulado)); ?>

                            </span>

                            <span class="kpi-sub">
                                sobre 5.0
                            </span>

                        </div>
                    </td>

                    <td class="kpi-td">
                        <div class="kpi-box">

                            <span class="kpi-bar"></span>

                            <span class="kpi-lbl">
                                Puesto en Clase
                            </span>

                            <span class="kpi-val">
                                <?php echo e($puesto ?? '—'); ?>

                            </span>

                            <span class="kpi-sub">
                                clasificación
                            </span>

                        </div>
                    </td>

                    <td class="kpi-td">
                        <div class="kpi-box">

                            <span class="kpi-bar"></span>

                            <span class="kpi-lbl">
                                Total de Asignaturas
                            </span>

                            <span class="kpi-val">
                                <?php echo e($scores->count()); ?>

                            </span>

                            <span class="kpi-sub">
                                evaluadas
                            </span>

                        </div>
                    </td>

                    <td class="kpi-td">
                        <div class="kpi-box">

                            <span class="kpi-bar"></span>

                            <span class="kpi-lbl">
                                Trimestre
                            </span>

                            <span class="kpi-val" style="font-size:15px;">
                                <?php echo e($period->name); ?>

                            </span>

                            <span class="kpi-sub">
                                <?php echo e($yearLectivo ?? '2025'); ?>

                            </span>

                        </div>
                    </td>

                </tr>
            </table>

        </div>

        
        <div class="mats-wrap">

            <?php $__currentLoopData = $scores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $score): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php

            $subject = optional($score->teacherSubject->subject)->name ?? 'Sin Asignatura';

            $teacher = optional(optional($score->teacherSubject->teacher)->user)->name ?? 'Sin docente';

            $horas = $score->teacherSubject->weekly_hours
                ?? $score->teacherSubject->hours_per_week
                ?? null;

            $comentarios = \App\Models\DimensionComment::where(
                    'teacher_subject_id',
                    $score->teacher_subject_id
                )
                ->where('period_id', $period->id)
                ->get()
                ->keyBy('dimension');

            $historial = $allScores[$score->teacher_subject_id] ?? collect();

            if ($isLastPeriod) {

                $histTotal = $historial->whereNotNull('total');

                $sum = 0;

                foreach ($histTotal as $h) {

                    $sum += floor((float)$h->total * 10) / 10;
                }

                $nota = $histTotal->count() > 0
                    ? $sum / $histTotal->count()
                    : 0;

            } else {

                $nota = $score->total ?? 0;
            }

            $notaFmt = truncar1($nota);

            $saberFmt = truncar1($score->saber ?? 0);

            $hacerFmt = truncar1($score->hacer ?? 0);

            $serFmt = truncar1($score->ser ?? 0);

            $prefijo = match(true) {
                $nota >= 4.6 => 'Siempre',
                $nota >= 4.0 => 'Casi siempre',
                $nota >= 3.0 => 'Algunas veces',
                default      => 'Con dificultad',
            };

            $nivelClass = match(true) {
                $nota >= 4.6 => 'nvl-superior',
                $nota >= 4.0 => 'nvl-alto',
                $nota >= 3.0 => 'nvl-basico',
                default      => 'nvl-bajo',
            };

            $nivelNombre = match(true) {
                $nota >= 4.6 => 'Superior',
                $nota >= 4.0 => 'Alto',
                $nota >= 3.0 => 'Básico',
                default      => 'Bajo',
            };

            ?>

            <div class="mat-card">

                <table class="mat-top">
                    <tr>

                        <td class="mat-izq-td">

                            <span class="mat-nom">
                                <?php echo e($subject); ?>

                            </span>

                            <span class="mat-doc">

                                Docente:
                                <?php echo e(strtoupper($teacher)); ?>


                                <?php if($horas): ?>

                                    <span class="mat-horas">
                                        · <?php echo e($horas); ?> h/sem
                                    </span>

                                <?php endif; ?>

                            </span>

                            <?php if($historial->isNotEmpty()): ?>

                                <div style="margin-top:3px;">

                                    <?php $__currentLoopData = $historial; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <span class="hist-pill">

                                            <?php echo e($h->period->name); ?>:
                                            <?php echo e(truncar1($h->total)); ?>


                                        </span>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </div>

                            <?php endif; ?>

                        </td>

                        <td class="mat-der-td">

                            <span class="nvl-badge <?php echo e($nivelClass); ?>">
                                <?php echo e($nivelNombre); ?>

                            </span>

                            <span class="mat-nota-g">
                                <?php echo e($notaFmt); ?>

                            </span>

                            <span class="mat-nota-lbl">
                                Nota Final
                            </span>

                        </td>

                    </tr>
                </table>

                <table class="dims-table">
                    <tr>

                        <td class="dim-td">

                            <table class="dim-inner">
                                <tr>

                                    <td>
                                        <span class="dim-ico d-s">S</span>
                                    </td>

                                    <td class="dim-lbl-td">

                                        <span class="dim-nm">
                                            Saber
                                        </span>

                                        <span class="dim-nt">
                                            <?php echo e($saberFmt); ?>

                                        </span>

                                    </td>

                                </tr>
                            </table>

                        </td>

                        <td class="dim-td">

                            <table class="dim-inner">
                                <tr>

                                    <td>
                                        <span class="dim-ico d-h">H</span>
                                    </td>

                                    <td class="dim-lbl-td">

                                        <span class="dim-nm">
                                            Hacer
                                        </span>

                                        <span class="dim-nt">
                                            <?php echo e($hacerFmt); ?>

                                        </span>

                                    </td>

                                </tr>
                            </table>

                        </td>

                        <td class="dim-td">

                            <table class="dim-inner">
                                <tr>

                                    <td>
                                        <span class="dim-ico d-p">P</span>
                                    </td>

                                    <td class="dim-lbl-td">

                                        <span class="dim-nm">
                                            Ser
                                        </span>

                                        <span class="dim-nt">
                                            <?php echo e($serFmt); ?>

                                        </span>

                                    </td>

                                </tr>
                            </table>

                        </td>

                    </tr>
                </table>

                <div class="coms-wrap">

                    <?php if($comentarios->isNotEmpty()): ?>

                        <?php $__currentLoopData = ['saber','hacer','ser']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dim): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <?php if(isset($comentarios[$dim]) && $comentarios[$dim]->comment): ?>

                                <table class="com-table">
                                    <tr>

                                        <td style="width:46px;padding-right:4px;">

                                            <span class="com-tag tag-<?php echo e($dim); ?>">
                                                <?php echo e(ucfirst($dim)); ?>

                                            </span>

                                        </td>

                                        <td>

                                            <span class="com-pre">
                                                <?php echo e($prefijo); ?>,
                                            </span>

                                            <?php echo e($comentarios[$dim]->comment); ?>


                                        </td>

                                    </tr>
                                </table>

                            <?php endif; ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php else: ?>

                        <span class="com-vacio">
                            Definitiva en la asignatura.
                        </span>

                    <?php endif; ?>

                </div>

            </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php if(!empty($disciplineComment) && $disciplineComment->comment): ?>

            <div class="mat-card mat-card-disciplina">

                <table class="mat-top">
                    <tr>

                        <td class="mat-izq-td">

                            <span class="mat-nom" style="color:#92400e;">

                                Disciplina y Comportamiento

                            </span>

                            <span class="mat-doc">

                                Director(a) de Grado:
                                <?php echo e(strtoupper($directorName ?? 'Director de Grupo')); ?>


                            </span>

                        </td>

                        <td class="mat-der-td">

                            <span class="nvl-badge <?php echo e($discNivelClass); ?>">
                                <?php echo e($discNivelNombre); ?>

                            </span>

                            <span class="mat-nota-g">
                        <?php echo e(truncar1($notaDisciplina)); ?>       
                        </span>

                            <span class="mat-nota-lbl">
                                Comportamiento
                            </span>

                        </td>

                    </tr>
                </table>

                <div class="coms-wrap">

                    <table class="com-table">
                        <tr>

                            <td>

                                <span class="com-pre">
                                    <?php echo e($discPrefijo); ?>,
                                </span>

                                <?php echo e($disciplineComment->comment); ?>


                            </td>

                        </tr>
                    </table>

                </div>

            </div>

            <?php endif; ?>

        </div>

        
        <div class="pie-wrap">

            <div class="escala-box">

                <span class="escala-t">
                    Escala de Valoración Nacional
                </span>

                <table class="escala-table">

                    <tr>

                        <td style="padding-right:14px;">

                            <span
                                class="escala-dot"
                                style="background:#fca5a5;border:1px solid #ef4444;"
                            ></span>

                            <span class="escala-txt">
                                <strong>Bajo</strong> · 1.0 – 2.9
                            </span>

                        </td>

                        <td style="padding-right:14px;">

                            <span
                                class="escala-dot"
                                style="background:#fcd34d;border:1px solid #f59e0b;"
                            ></span>

                            <span class="escala-txt">
                                <strong>Básico</strong> · 3.0 – 3.9
                            </span>

                        </td>

                        <td style="padding-right:14px;">

                            <span
                                class="escala-dot"
                                style="background:#d6e4f7;border:1px solid #2d5da8;"
                            ></span>

                            <span class="escala-txt">
                                <strong>Alto</strong> · 4.0 – 4.5
                            </span>

                        </td>

                        <td>

                            <span
                                class="escala-dot"
                                style="background:#6ee7b7;border:1px solid #10b981;"
                            ></span>

                            <span class="escala-txt">
                                <strong>Superior</strong> · 4.6 – 5.0
                            </span>

                        </td>

                    </tr>

                </table>

            </div>

            <table class="firmas-table">
                <tr>

                    <td class="firma-td">

                        <span class="firma-linea"></span>

                        <span class="firma-nom">
                            <?php echo e($directorName ?? 'Director de Grupo'); ?>

                        </span>

                        <span class="firma-car">
                            Director(a) de Grado
                        </span>

                    </td>

                    <td class="firma-td">

                        <span class="firma-linea"></span>

                        <span class="firma-nom">
                            Rector(a)
                        </span>

                        <span class="firma-car">
                            Rector(a)
                        </span>

                    </td>

                </tr>
            </table>

        </div>

        <div class="nota-pie">

            <table class="nota-pie-table">
                <tr>

                    <td>
                        Instituto Técnico Agropecuario y Forestal · El Tambo, Cauca
                    </td>

                    <td class="nota-pie-right">
                        Documento oficial · <?php echo e(now()->format('d/m/Y')); ?>

                    </td>

                </tr>
            </table>

        </div>

        <span class="franja-gold"></span>
        <span class="franja-bot"></span>

    </div>

</div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</body>
</html><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/boletin/pdf_masivo.blade.php ENDPATH**/ ?>