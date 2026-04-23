<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boletines Masivos</title>
    <style>
        * { box-sizing: border-box !important; margin: 0; padding: 0; }
        html, body { font-family: 'DejaVu Sans', sans-serif; font-size: 8px; color: #111827; background: #ffffff; }

        .pagina-boletin { page-break-after: always; }
        .pagina-boletin:last-child { page-break-after: auto; }

        .bol-wrap { width:100%; background:#fff; -webkit-print-color-adjust:exact; print-color-adjust:exact; }
        .franja-top  { display:block; height:3px;  background:#1a3a6b; font-size:0; line-height:0; }
        .franja-gold { display:block; height:1.5px; background:#c89b3c; font-size:0; line-height:0; }
        .franja-bot  { display:block; height:3px;  background:#1a3a6b; font-size:0; line-height:0; }

        /* ── CABECERA ── */
        .cab-table { width:100%; border-collapse:collapse; background:#fff; border-bottom:1px solid #d6e4f7; }
        .cab-table td { vertical-align:middle; padding:5px 6px; }
        .cab-logo-td { width:46px; padding-left:8px !important; vertical-align:middle !important; }
        .cab-inst-td { padding-left:7px !important; vertical-align:middle !important; }
        .cab-meta-td { width:115px; text-align:right; padding-right:8px !important; vertical-align:top !important; padding-top:5px !important; }
        .logo-fb { font-size:10px; font-weight:700; color:#fff; line-height:36px; display:block; text-align:center; }
        .inst-nom { font-size:9.5px; font-weight:700; color:#1a3a6b; display:block; margin-bottom:2px; line-height:1.2; }
        .inst-sub { font-size:6.5px; color:#6b7280; line-height:1.7; display:block; }
        .bol-badge { display:inline-block; background:#1a3a6b; color:#fff; font-size:6.5px; font-weight:700; padding:1px 6px; border-radius:3px; margin-bottom:3px; }
        .meta-fila { font-size:6.5px; color:#374151; line-height:1.8; display:block; }
        .meta-fila strong { color:#1a3a6b; font-weight:600; }

        /* ── ESTUDIANTE ── */
        .est-wrap { padding:5px 9px 0; }
        .est-table { width:100%; border-collapse:collapse; background:#1a3a6b; border-radius:5px; overflow:hidden; }
        .est-table td { vertical-align:middle; padding:5px 8px; }
        .est-sep { width:1px; border-left:1px solid rgba(255,255,255,0.2); padding:0 !important; }
        .est-dato-td { width:72px; text-align:center; }
        .est-lbl { font-size:5.5px; font-weight:500; text-transform:uppercase; letter-spacing:.7px; color:rgba(255,255,255,0.6); display:block; margin-bottom:1px; }
        .est-nom { font-size:10.5px; font-weight:700; color:#fff; line-height:1.1; display:block; }
        .est-dlbl { font-size:5.5px; text-transform:uppercase; letter-spacing:.3px; color:rgba(255,255,255,0.55); display:block; margin-bottom:1px; }
        .est-dval { font-size:9px; font-weight:600; color:#fff; display:block; }

        /* ── KPIs ── */
        .kpis-wrap { padding:5px 9px; }
        .kpis-table { width:100%; border-collapse:separate; border-spacing:4px 0; }
        .kpi-td { width:25%; vertical-align:top; }
        .kpi-box { background:#fff; border:1px solid #d1d5db; border-radius:4px; text-align:center; padding:3px 3px 5px; overflow:hidden; }
        .kpi-bar { display:block; height:2px; background:#2d5da8; margin:-3px -3px 3px -3px; border-radius:2px 2px 0 0; }
        .kpi-lbl { font-size:5.5px; text-transform:uppercase; letter-spacing:.4px; color:#6b7280; display:block; margin-bottom:1px; }
        .kpi-val { font-size:13px; font-weight:700; color:#1a3a6b; line-height:1; display:block; }
        .kpi-sub { font-size:5.5px; color:#9ca3af; display:block; margin-top:1px; }

        /* ── MATERIAS ── */
        .mats-wrap { padding:0 9px 8px; }
        .sec-hdr-table { width:100%; border-collapse:collapse; margin-bottom:5px; }
        .sec-hdr-td-t { white-space:nowrap; padding:0 6px; font-size:6px; font-weight:600; text-transform:uppercase; letter-spacing:1px; color:#1a3a6b; }
        .mat-card { border:1px solid #d1d5db; border-radius:5px; overflow:hidden; margin-bottom:4px; background:#fff; page-break-inside:avoid; }
        .mat-top { width:100%; border-collapse:collapse; background:#eef4fc; border-bottom:1px solid #d6e4f7; }
        .mat-top td { vertical-align:middle; }
        .mat-izq-td { padding:4px 8px; }
        .mat-nom { font-size:8px; font-weight:700; color:#1a3a6b; display:block; margin-bottom:1px; line-height:1.2; }
        .mat-doc { font-size:6px; color:#6b7280; font-style:italic; display:block; margin-bottom:1px; }
        .hist-pill { display:inline-block; background:#d6e4f7; color:#1a3a6b; padding:1px 4px; border-radius:20px; font-size:5.5px; font-weight:500; margin-right:2px; }
        .mat-der-td { width:64px; border-left:1px solid #d6e4f7; text-align:center; padding:3px 4px; vertical-align:middle; }
        .nvl-badge { display:block; font-size:5.5px; font-weight:700; text-transform:uppercase; padding:1px 0; border-radius:20px; margin-bottom:1px; text-align:center; }
        .nvl-bajo     { background:#fdf0f0; color:#9b1c1c; border:1px solid #fca5a5; }
        .nvl-basico   { background:#fef3e2; color:#b45309; border:1px solid #fcd34d; }
        .nvl-alto     { background:#eef4fc; color:#1a3a6b; border:1px solid #d6e4f7; }
        .nvl-superior { background:#e6f4ec; color:#1e6b45; border:1px solid #6ee7b7; }
        .mat-nota-g { font-size:18px; font-weight:700; color:#111827; line-height:1; display:block; }
        .mat-nota-lbl { font-size:5.5px; text-transform:uppercase; letter-spacing:.3px; color:#6b7280; }

        /* ── DIMENSIONES ── */
        .dims-table { width:100%; border-collapse:collapse; border-bottom:1px dashed #e5e7eb; }
        .dim-td { padding:3px 8px; width:33.33%; border-right:1px solid #e5e7eb; vertical-align:middle; }
        .dim-td:last-child { border-right:none; }
        .dim-inner { border-collapse:collapse; }
        .dim-inner td { vertical-align:middle; }
        .dim-ico { width:14px; height:14px; border-radius:3px; font-size:7px; font-weight:700; text-align:center; line-height:14px; display:block; }
        .d-s { background:#dbeafe; color:#1e40af; }
        .d-h { background:#d1fae5; color:#065f46; }
        .d-p { background:#ede9fe; color:#4c1d95; }
        .dim-lbl-td { padding-left:4px; }
        .dim-nm { font-size:5.5px; text-transform:uppercase; letter-spacing:.3px; color:#6b7280; font-weight:500; display:block; }
        .dim-nt { font-size:10px; font-weight:700; color:#111827; line-height:1.1; display:block; }

        /* ── COMENTARIOS ── */
        .coms-wrap { padding:3px 8px 4px; background:#fafbfc; }
        .com-table { width:100%; border-collapse:collapse; border-top:1px solid #f3f4f6; }
        .com-table:first-child { border-top:none; }
        .com-table td { font-size:6.5px; color:#374151; padding:1px 0; line-height:1.4; vertical-align:top; }
        .com-tag { display:inline-block; font-size:5.5px; font-weight:700; text-transform:uppercase; padding:1px 3px; border-radius:3px; white-space:nowrap; }
        .tag-saber { background:#dbeafe; color:#1e40af; }
        .tag-hacer { background:#d1fae5; color:#065f46; }
        .tag-ser   { background:#ede9fe; color:#4c1d95; }
        .com-pre { color:#2d5da8; font-style:italic; font-weight:500; white-space:nowrap; padding:0 2px; }
        .com-vacio { font-size:6px; color:#9ca3af; font-style:italic; }

        /* ── PIE ── */
        .pie-wrap { padding:0 9px 8px; }
        .escala-box { border:1px solid #d1d5db; border-radius:4px; padding:3px 8px; background:#f9fafb; margin-bottom:7px; }
        .escala-t { font-size:5.5px; font-weight:600; text-transform:uppercase; letter-spacing:.5px; color:#6b7280; margin-bottom:3px; display:block; }
        .escala-table { border-collapse:collapse; }
        .escala-dot { width:7px; height:7px; border-radius:2px; display:inline-block; margin-right:3px; vertical-align:middle; }
        .escala-txt { font-size:6.5px; color:#374151; white-space:nowrap; }
        .firmas-table { width:100%; border-collapse:collapse; }
        .firma-td { width:33.33%; text-align:center; padding:0 6px; }
        .firma-linea { height:22px; border-bottom:1px solid #111827; display:block; margin-bottom:2px; }
        .firma-nom { font-size:6.5px; font-weight:600; color:#111827; display:block; }
        .firma-car { font-size:5.5px; color:#6b7280; display:block; }

        /* ── NOTA PIE ── */
        .nota-pie { background:#1a3a6b; padding:3px 9px; }
        .nota-pie-table { width:100%; border-collapse:collapse; }
        .nota-pie-table td { font-size:5.5px; color:rgba(255,255,255,0.65); padding:0; vertical-align:middle; }
        .nota-pie-right { text-align:right; }
        .marca-agua { position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); width:220px; height:220px; object-fit:contain; opacity:0.04; pointer-events:none; z-index:0; }

        @page { size: A4; margin: 0; }
        @media print {
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            .mat-card { page-break-inside: avoid; }
        }
    </style>
</head>
<body>

<?php
    $isLastPeriod = isset($isLastPeriod)
        ? $isLastPeriod
        : (\App\Models\Period::where('academic_year_id', $period->academic_year_id)
              ->orderBy('id')->pluck('id')->last() == $period->id);
?>

<?php $__currentLoopData = $boletines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $student   = $data['student'];
        $scores    = $data['scores'];
        $allScores = $data['allScores'];
        $puesto    = $data['puesto'];
        $grade     = $data['grade'];
    ?>

    <div class="pagina-boletin">
        <?php echo $__env->make('admin.boletin.boletin', [
            'student'      => $student,
            'scores'       => $scores,
            'allScores'    => $allScores,
            'puesto'       => $puesto,
            'grade'        => $grade,
            'period'       => $period,
            'yearLectivo'  => $yearLectivo,
            'logoBase64'   => $logoBase64,
            'isLastPeriod' => $isLastPeriod,
            'isPdf'        => true,
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</body>
</html><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/boletin/pdf_masivo.blade.php ENDPATH**/ ?>