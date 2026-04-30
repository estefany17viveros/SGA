<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boletines Masivos</title>
    <style>
    * { box-sizing: border-box !important; margin: 0; padding: 0; }
    html, body { font-family: 'DejaVu Sans', sans-serif; font-size: 7px; color: #111827; background: #ffffff; }

    .pagina-boletin { page-break-after: always; }
    .pagina-boletin:last-child { page-break-after: auto; }

    .bol-wrap { width: 100%; background: #fff; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .franja-top  { display: block; height: 3px; background: #1a3a6b; font-size: 0; line-height: 0; }
    .franja-gold { display: block; height: 1.5px; background: #c89b3c; font-size: 0; line-height: 0; }
    .franja-bot  { display: block; height: 3px; background: #1a3a6b; font-size: 0; line-height: 0; }

    /* ── MARCA DE AGUA ── */
    .marca-agua { position: fixed; top: 50%; left: 50%; transform: translate(-50%,-50%); width: 200px; height: 200px; object-fit: contain; opacity: 0.04; pointer-events: none; z-index: 0; }

    /* ── CABECERA ── */
    .cab-table { width: 100%; border-collapse: collapse; background: #fff; border-bottom: 0.5px solid #d6e4f7; }
    .cab-table td { vertical-align: middle; padding: 4px 5px; }
    .cab-logo-td { width: 44px; padding-left: 7px !important; vertical-align: middle !important; }
    .cab-inst-td { padding-left: 6px !important; vertical-align: middle !important; }
    .cab-meta-td { width: 108px; text-align: right; padding-right: 7px !important; vertical-align: top !important; padding-top: 4px !important; }
    .logo-fb { font-size: 9px; font-weight: 700; color: #fff; line-height: 56px; display: block; text-align: center; }
    .inst-nom { font-size: 8.5px; font-weight: 700; color: #1a3a6b; display: block; margin-bottom: 1px; line-height: 1.2; }
    .inst-sub { font-size: 5.5px; color: #6b7280; line-height: 1.6; display: block; }
    .bol-badge { display: inline-block; background: #1a3a6b; color: #fff; font-size: 6px; font-weight: 700; padding: 1px 5px; border-radius: 3px; margin-bottom: 2px; }
    .meta-fila { font-size: 6px; color: #374151; line-height: 1.75; display: block; }
    .meta-fila strong { color: #1a3a6b; font-weight: 600; }

    /* ── ESTUDIANTE ── */
    .est-wrap { padding: 4px 8px 0; }
    .est-table { width: 100%; border-collapse: collapse; background: #1a3a6b; border-radius: 4px; overflow: hidden; }
    .est-table td { vertical-align: middle; padding: 5px 7px; }
    .est-sep { width: 0.5px; border-left: 0.5px solid rgba(255,255,255,0.2); padding: 0 !important; }
    .est-dato-td { width: 70px; text-align: center; }
    .est-lbl { font-size: 5px; font-weight: 500; text-transform: uppercase; letter-spacing: .6px; color: rgba(255,255,255,0.55); display: block; margin-bottom: 1px; }
    .est-nom { font-size: 9.5px; font-weight: 700; color: #fff; line-height: 1.1; display: block; }
    .est-dlbl { font-size: 5px; text-transform: uppercase; letter-spacing: .3px; color: rgba(255,255,255,0.5); display: block; margin-bottom: 1px; }
    .est-dval { font-size: 8px; font-weight: 600; color: #fff; display: block; }

    /* ── KPIs ── */
    .kpis-wrap { padding: 5px 8px; }
    .kpis-table { width: 100%; border-collapse: separate; border-spacing: 3px 0; }
    .kpi-td { width: 25%; vertical-align: top; }
    .kpi-box { background: #f8fafc; border: 0.5px solid #d1d5db; border-radius: 4px; text-align: center; padding: 3px 3px 4px; overflow: hidden; }
    .kpi-bar { display: block; height: 2px; background: #2d5da8; margin: -3px -3px 3px -3px; border-radius: 2px 2px 0 0; }
    .kpi-lbl { font-size: 5px; text-transform: uppercase; letter-spacing: .4px; color: #6b7280; display: block; margin-bottom: 1px; }
    .kpi-val { font-size: 12px; font-weight: 700; color: #1a3a6b; line-height: 1; display: block; }
    .kpi-sub { font-size: 5px; color: #9ca3af; display: block; margin-top: 1px; }

    /* ── MATERIAS ── */
    .mats-wrap { padding: 0 8px 7px; }
    .sec-hdr-table { width: 100%; border-collapse: collapse; margin-bottom: 4px; }
    .sec-hdr-td-t { white-space: nowrap; padding: 0 5px; font-size: 5.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; color: #1a3a6b; }
    .mat-card { border: 0.5px solid #d1d5db; border-radius: 4px; overflow: hidden; margin-bottom: 3px; background: #fff; page-break-inside: avoid; }
    .mat-top { width: 100%; border-collapse: collapse; background: #eef4fc; border-bottom: 0.5px solid #d6e4f7; }
    .mat-top td { vertical-align: middle; }
    .mat-izq-td { padding: 4px 7px; }
    .mat-nom { font-size: 7.5px; font-weight: 700; color: #1a3a6b; display: block; margin-bottom: 1px; line-height: 1.2; }
    .mat-doc { font-size: 5.5px; color: #6b7280; font-style: italic; display: block; margin-bottom: 2px; }
    .hist-pill { display: inline-block; background: #d6e4f7; color: #1a3a6b; padding: 1px 4px; border-radius: 20px; font-size: 5px; font-weight: 500; margin-right: 2px; }
    .mat-der-td { width: 58px; border-left: 0.5px solid #d6e4f7; text-align: center; padding: 3px 4px; vertical-align: middle; }
    .nvl-badge { display: block; font-size: 5px; font-weight: 700; text-transform: uppercase; padding: 1px 0; border-radius: 20px; margin-bottom: 2px; text-align: center; }
    .nvl-bajo     { background: #fdf0f0; color: #9b1c1c; border: 0.5px solid #fca5a5; }
    .nvl-basico   { background: #fef3e2; color: #b45309; border: 0.5px solid #fcd34d; }
    .nvl-alto     { background: #eef4fc; color: #1a3a6b; border: 0.5px solid #d6e4f7; }
    .nvl-superior { background: #e6f4ec; color: #1e6b45; border: 0.5px solid #6ee7b7; }
    .mat-nota-g { font-size: 17px; font-weight: 700; color: #111827; line-height: 1; display: block; }
    .mat-nota-lbl { font-size: 5px; text-transform: uppercase; letter-spacing: .3px; color: #6b7280; }

    /* ── DIMENSIONES ── */
    .dims-table { width: 100%; border-collapse: collapse; border-bottom: 0.5px dashed #e5e7eb; }
    .dim-td { padding: 3px 7px; width: 33.33%; border-right: 0.5px solid #e5e7eb; vertical-align: middle; }
    .dim-td:last-child { border-right: none; }
    .dim-inner { border-collapse: collapse; }
    .dim-inner td { vertical-align: middle; }
    .dim-ico { width: 13px; height: 13px; border-radius: 3px; font-size: 6.5px; font-weight: 700; text-align: center; line-height: 13px; display: block; }
    .d-s { background: #dbeafe; color: #1e40af; }
    .d-h { background: #d1fae5; color: #065f46; }
    .d-p { background: #ede9fe; color: #4c1d95; }
    .dim-lbl-td { padding-left: 3px; }
    .dim-nm { font-size: 5px; text-transform: uppercase; letter-spacing: .3px; color: #6b7280; font-weight: 500; display: block; }
    .dim-nt { font-size: 9px; font-weight: 700; color: #111827; line-height: 1.1; display: block; }

    /* ── COMENTARIOS ── */
    .coms-wrap { padding: 3px 7px 4px; background: #fafbfc; }
    .com-table { width: 100%; border-collapse: collapse; border-top: 0.5px solid #f3f4f6; }
    .com-table:first-child { border-top: none; }
    .com-table td { font-size: 6px; color: #374151; padding: 1px 0; line-height: 1.4; vertical-align: top; }
    .com-tag { display: inline-block; font-size: 5px; font-weight: 700; text-transform: uppercase; padding: 1px 3px; border-radius: 3px; white-space: nowrap; }
    .tag-saber { background: #dbeafe; color: #1e40af; }
    .tag-hacer { background: #d1fae5; color: #065f46; }
    .tag-ser   { background: #ede9fe; color: #4c1d95; }
    .com-pre { color: #2d5da8; font-style: italic; font-weight: 500; white-space: nowrap; padding: 0 2px; }
    .com-vacio { font-size: 5.5px; color: #9ca3af; font-style: italic; }

    /* ── PIE ── */
    .pie-wrap { padding: 0 8px 8px; }
    .escala-box { border: 0.5px solid #d1d5db; border-radius: 4px; padding: 3px 7px; background: #f9fafb; margin-bottom: 6px; }
    .escala-t { font-size: 5px; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; color: #6b7280; margin-bottom: 3px; display: block; }
    .escala-table { border-collapse: collapse; }
    .escala-dot { width: 7px; height: 7px; border-radius: 2px; display: inline-block; margin-right: 3px; vertical-align: middle; }
    .escala-txt { font-size: 6px; color: #374151; white-space: nowrap; }
    .firmas-table { width: 100%; border-collapse: collapse; }
    .firma-td { width: 33.33%; text-align: center; padding: 0 5px; }
    .firma-linea { height: 20px; border-bottom: 0.5px solid #111827; display: block; margin-bottom: 2px; }
    .firma-nom { font-size: 6px; font-weight: 600; color: #111827; display: block; }
    .firma-car { font-size: 5px; color: #6b7280; display: block; }

    /* ── NOTA PIE ── */
    .nota-pie { background: #1a3a6b; padding: 3px 8px; }
    .nota-pie-table { width: 100%; border-collapse: collapse; }
    .nota-pie-table td { font-size: 5px; color: rgba(255,255,255,0.65); padding: 0; vertical-align: middle; }
    .nota-pie-right { text-align: right; }

    @page { size: A4; margin: 0; }
    @media print {
        * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        .mat-card { page-break-inside: avoid; }
    }
    </style>
</head>
<body>

@php
    $isLastPeriod = isset($isLastPeriod)
        ? $isLastPeriod
        : (\App\Models\Period::where('academic_year_id', $period->academic_year_id)
              ->orderBy('id')->pluck('id')->last() == $period->id);
@endphp

@foreach($boletines as $data)
    @php
        $student   = $data['student'];
        $scores    = $data['scores'];
        $allScores = $data['allScores'];
        $puesto    = $data['puesto'];
        $grade     = $data['grade'];
    @endphp

    <div class="pagina-boletin">
        @include('admin.boletin.boletin', [
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
        ])
    </div>

@endforeach

</body>
</html>