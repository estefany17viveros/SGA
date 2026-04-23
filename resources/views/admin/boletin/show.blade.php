@extends('layouts.print')

@section('content')
<style>
/* ════════════════════════════════════════
   RESET GLOBAL — compatible DomPDF
════════════════════════════════════════ */
* { box-sizing: border-box !important; margin: 0; padding: 0; }
html, body { font-family: 'DejaVu Sans', sans-serif; font-size: 9px; color: #111827; background: #ffffff; width: 100%; height: 100%; }
.bol-wrap { width: 100%; min-height: 100vh; background: #ffffff; -webkit-print-color-adjust: exact; print-color-adjust: exact; }

/* ── Franjas ── */
.franja-top  { display: block; height: 5px;  background: #1a3a6b; font-size:0; line-height:0; }
.franja-gold { display: block; height: 2px;  background: #c89b3c; font-size:0; line-height:0; }
.franja-bot  { display: block; height: 5px;  background: #1a3a6b; font-size:0; line-height:0; }

/* ════ CABECERA ════ */
.cab-table { width:100%; border-collapse:collapse; background:#fff; border-bottom:1.5px solid #d6e4f7; }
.cab-table td { vertical-align:middle; padding:8px 8px; }
.cab-logo-td { width:60px; padding-left:12px !important; vertical-align:middle !important; }
.cab-inst-td { padding-left:10px !important; vertical-align:middle !important; }
.cab-meta-td { width:140px; text-align:right; padding-right:12px !important; vertical-align:top !important; padding-top:8px !important; }
.logo-fb { font-size:13px; font-weight:700; color:#fff; line-height:48px; display:block; text-align:center; }
.inst-nom { font-size:11.5px; font-weight:700; color:#1a3a6b; display:block; margin-bottom:3px; line-height:1.2; }
.inst-sub { font-size:7.5px; color:#6b7280; line-height:1.8; display:block; }
.bol-badge { display:inline-block; background:#1a3a6b; color:#fff; font-size:8px; font-weight:700; padding:2px 8px; border-radius:3px; margin-bottom:4px; }
.meta-fila { font-size:7.5px; color:#374151; line-height:1.9; display:block; }
.meta-fila strong { color:#1a3a6b; font-weight:600; }

/* ════ ESTUDIANTE ════ */
.est-wrap { padding:8px 12px 0; }
.est-table { width:100%; border-collapse:collapse; background:#1a3a6b; border-radius:6px; overflow:hidden; }
.est-table td { vertical-align:middle; padding:8px 10px; }
.est-sep { width:1px; border-left:1px solid rgba(255,255,255,0.2); padding:0 !important; }
.est-dato-td { width:88px; text-align:center; }
.est-lbl { font-size:6.5px; font-weight:500; text-transform:uppercase; letter-spacing:.8px; color:rgba(255,255,255,0.6); display:block; margin-bottom:1px; }
.est-nom { font-size:13px; font-weight:700; color:#fff; line-height:1.1; display:block; }
.est-dlbl { font-size:6px; text-transform:uppercase; letter-spacing:.4px; color:rgba(255,255,255,0.55); display:block; margin-bottom:1px; }
.est-dval { font-size:11px; font-weight:600; color:#fff; display:block; }

/* ════ KPIs ════ */
.kpis-wrap { padding:7px 12px; }
.kpis-table { width:100%; border-collapse:separate; border-spacing:6px 0; }
.kpi-td { width:25%; vertical-align:top; }
.kpi-box { background:#fff; border:1px solid #d1d5db; border-radius:5px; text-align:center; padding:5px 4px 7px; overflow:hidden; }
.kpi-bar { display:block; height:2px; background:#2d5da8; margin:-5px -4px 5px -4px; border-radius:2px 2px 0 0; }
.kpi-lbl { font-size:6.5px; text-transform:uppercase; letter-spacing:.4px; color:#6b7280; display:block; margin-bottom:1px; }
.kpi-val { font-size:16px; font-weight:700; color:#1a3a6b; line-height:1; display:block; }
.kpi-sub { font-size:6.5px; color:#9ca3af; display:block; margin-top:1px; }

/* ════ MATERIAS ════ */
.mats-wrap { padding:0 12px 10px; }
.sec-hdr-table { width:100%; border-collapse:collapse; margin-bottom:7px; }
.sec-hdr-td-t { white-space:nowrap; padding:0 8px; font-size:6.5px; font-weight:600; text-transform:uppercase; letter-spacing:1px; color:#1a3a6b; }

/* Tarjeta materia */
.mat-card { border:1px solid #d1d5db; border-radius:6px; overflow:hidden; margin-bottom:6px; background:#fff; page-break-inside:avoid; }
.mat-top { width:100%; border-collapse:collapse; background:#eef4fc; border-bottom:1px solid #d6e4f7; }
.mat-top td { vertical-align:middle; }
.mat-izq-td { padding:6px 10px; }
.mat-nom { font-size:9.5px; font-weight:700; color:#1a3a6b; display:block; margin-bottom:1px; line-height:1.2; }
.mat-doc { font-size:7px; color:#6b7280; font-style:italic; display:block; margin-bottom:2px; }
.hist-pill { display:inline-block; background:#d6e4f7; color:#1a3a6b; padding:1px 5px; border-radius:20px; font-size:6.5px; font-weight:500; margin-right:2px; }
.mat-der-td { width:78px; border-left:1px solid #d6e4f7; text-align:center; padding:5px 6px; vertical-align:middle; }
.nvl-badge { display:block; font-size:6.5px; font-weight:700; text-transform:uppercase; padding:1px 0; border-radius:20px; margin-bottom:2px; text-align:center; }
.nvl-bajo     { background:#fdf0f0; color:#9b1c1c; border:1px solid #fca5a5; }
.nvl-basico   { background:#fef3e2; color:#b45309; border:1px solid #fcd34d; }
.nvl-alto     { background:#eef4fc; color:#1a3a6b; border:1px solid #d6e4f7; }
.nvl-superior { background:#e6f4ec; color:#1e6b45; border:1px solid #6ee7b7; }
.mat-nota-g { font-size:22px; font-weight:700; color:#111827; line-height:1; display:block; }
.mat-nota-lbl { font-size:6px; text-transform:uppercase; letter-spacing:.3px; color:#6b7280; }

/* Dimensiones */
.dims-table { width:100%; border-collapse:collapse; border-bottom:1px dashed #e5e7eb; }
.dim-td { padding:5px 10px; width:33.33%; border-right:1px solid #e5e7eb; vertical-align:middle; }
.dim-td:last-child { border-right:none; }
.dim-inner { border-collapse:collapse; }
.dim-inner td { vertical-align:middle; }
.dim-ico { width:18px; height:18px; border-radius:4px; font-size:8px; font-weight:700; text-align:center; line-height:18px; display:block; }
.d-s { background:#dbeafe; color:#1e40af; }
.d-h { background:#d1fae5; color:#065f46; }
.d-p { background:#ede9fe; color:#4c1d95; }
.dim-lbl-td { padding-left:5px; }
.dim-nm { font-size:6.5px; text-transform:uppercase; letter-spacing:.3px; color:#6b7280; font-weight:500; display:block; }
.dim-nt { font-size:12px; font-weight:700; color:#111827; line-height:1.1; display:block; }

/* Comentarios */
.coms-wrap { padding:4px 10px 6px; background:#fafbfc; }
.com-table { width:100%; border-collapse:collapse; border-top:1px solid #f3f4f6; }
.com-table:first-child { border-top:none; }
.com-table td { font-size:7.5px; color:#374151; padding:1px 0; line-height:1.4; vertical-align:top; }
.com-tag { display:inline-block; font-size:6.5px; font-weight:700; text-transform:uppercase; padding:1px 4px; border-radius:3px; white-space:nowrap; }
.tag-saber { background:#dbeafe; color:#1e40af; }
.tag-hacer { background:#d1fae5; color:#065f46; }
.tag-ser   { background:#ede9fe; color:#4c1d95; }
.com-pre { color:#2d5da8; font-style:italic; font-weight:500; white-space:nowrap; padding:0 3px; }
.com-vacio { font-size:7px; color:#9ca3af; font-style:italic; }

/* ════ PIE ════ */
.pie-wrap { padding:0 12px 10px; }
.escala-box { border:1px solid #d1d5db; border-radius:5px; padding:5px 10px; background:#f9fafb; margin-bottom:10px; }
.escala-t { font-size:6.5px; font-weight:600; text-transform:uppercase; letter-spacing:.5px; color:#6b7280; margin-bottom:4px; display:block; }
.escala-table { border-collapse:collapse; }
.escala-dot { width:8px; height:8px; border-radius:2px; display:inline-block; margin-right:3px; vertical-align:middle; }
.escala-txt { font-size:7.5px; color:#374151; white-space:nowrap; }
.firmas-table { width:100%; border-collapse:collapse; }
.firma-td { width:33.33%; text-align:center; padding:0 8px; }
.firma-linea { height:28px; border-bottom:1px solid #111827; display:block; margin-bottom:3px; }
.firma-nom { font-size:7.5px; font-weight:600; color:#111827; display:block; }
.firma-car { font-size:6.5px; color:#6b7280; display:block; }

/* Pie azul */
.nota-pie { background:#1a3a6b; padding:4px 12px; }
.nota-pie-table { width:100%; border-collapse:collapse; }
.nota-pie-table td { font-size:6.5px; color:rgba(255,255,255,0.65); padding:0; vertical-align:middle; }
.nota-pie-right { text-align:right; }

/* Marca de agua */
.marca-agua { position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); width:260px; height:260px; object-fit:contain; opacity:0.04; pointer-events:none; z-index:0; }

/* Botón web */
.btn-pdf-wrap { text-align:center; padding:14px 0 22px; background:#f3f4f6; }
.btn-pdf { display:inline-block; background:#1a3a6b; color:#fff; padding:8px 20px; border-radius:6px; text-decoration:none; font-size:11px; font-weight:600; }

@page { size: A4; margin: 0; }
@media print {
    html, body { background:#fff !important; margin:0 !important; padding:0 !important; }
    .bol-wrap { width:100% !important; min-height:100% !important; }
    .btn-pdf-wrap { display:none !important; }
    .mat-card { page-break-inside:avoid; }
    * { -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important; }
}
</style>

@include('admin.boletin.boletin')

@if(!isset($isPdf))
<div class="btn-pdf-wrap">
    <a class="btn-pdf" href="{{ route('admin.boletin.pdf', [$student->id, $period->id]) }}">
        ⬇ Descargar PDF
    </a>
</div>
@endif

@endsection