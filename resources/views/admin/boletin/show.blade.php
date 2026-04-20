@extends('layouts.print')

@section('content')
<style>
/* ════════════════════════════════════════
   RESET GLOBAL — compatible DomPDF
   SIN flexbox, SIN grid → solo table-layout
════════════════════════════════════════ */
* { box-sizing: border-box !important; margin: 0; padding: 0; }

html, body {
  font-family: 'DejaVu Sans', sans-serif;
  font-size: 10px;
  color: #111827;
  background: #ffffff;
  width: 100%;
  height: 100%;
}

/* ── Contenedor ocupa toda la página ── */
.bol-wrap {
  width: 100%;
  min-height: 100vh;
  background: #ffffff;
  -webkit-print-color-adjust: exact;
  print-color-adjust: exact;
}

/* ── Franjas decorativas ── */
.franja-top  { display: block; height: 7px;  background: #1a3a6b; font-size:0; line-height:0; }
.franja-gold { display: block; height: 3px;  background: #c89b3c; font-size:0; line-height:0; }
.franja-bot  { display: block; height: 7px;  background: #1a3a6b; font-size:0; line-height:0; }

/* ════════════════
   CABECERA
════════════════ */
.cab-table {
  width: 100%;
  border-collapse: collapse;
  background: #ffffff;
  border-bottom: 2px solid #d6e4f7;
}
.cab-table td { vertical-align: middle; padding: 13px 10px; }
.cab-logo-td  { width: 80px; padding-left: 18px !important; vertical-align: middle !important; }
.cab-inst-td  { padding-left: 12px !important; vertical-align: middle !important; }
.cab-meta-td  {
  width: 165px; text-align: right;
  padding-right: 18px !important;
  vertical-align: top !important;
  padding-top: 13px !important;
}

.logo-fb {
  font-size: 16px; font-weight: 700; color: #fff;
  line-height: 62px; display: block; text-align: center;
}

.inst-nom {
  font-size: 15px; font-weight: 700; color: #1a3a6b;
  display: block; margin-bottom: 4px; line-height: 1.2;
}
.inst-sub { font-size: 8.5px; color: #6b7280; line-height: 2; display: block; }

.bol-badge {
  display: inline-block;
  background: #1a3a6b; color: #fff;
  font-size: 10px; font-weight: 700;
  padding: 3px 11px; border-radius: 4px;
  margin-bottom: 6px;
}
.meta-fila { font-size: 8.5px; color: #374151; line-height: 2.1; display: block; }
.meta-fila strong { color: #1a3a6b; font-weight: 600; }

/* ════════════════
   ESTUDIANTE
════════════════ */
.est-wrap { padding: 12px 18px 0; }
.est-table {
  width: 100%; border-collapse: collapse;
  background: #1a3a6b; border-radius: 8px; overflow: hidden;
}
.est-table td { vertical-align: middle; padding: 11px 14px; }
.est-sep { width: 1px; border-left: 1px solid rgba(255,255,255,0.2); padding: 0 !important; }
.est-dato-td { width: 100px; text-align: center; }

.est-lbl {
  font-size: 7.5px; font-weight: 500; text-transform: uppercase;
  letter-spacing: 1px; color: rgba(255,255,255,0.6);
  display: block; margin-bottom: 2px;
}
.est-nom {
  font-size: 16px; font-weight: 700; color: #fff;
  line-height: 1.1; display: block;
}
.est-dlbl {
  font-size: 7px; text-transform: uppercase; letter-spacing: 0.5px;
  color: rgba(255,255,255,0.55); display: block; margin-bottom: 2px;
}
.est-dval { font-size: 13px; font-weight: 600; color: #fff; display: block; }

/* ════════════════
   KPIs
════════════════ */
.kpis-wrap { padding: 10px 18px; }
.kpis-table { width: 100%; border-collapse: separate; border-spacing: 8px 0; }
.kpi-td { width: 25%; vertical-align: top; }
.kpi-box {
  background: #fff; border: 1.5px solid #d1d5db;
  border-radius: 7px; text-align: center;
  padding: 8px 6px 10px; overflow: hidden;
}
.kpi-bar {
  display: block; height: 3px; background: #2d5da8;
  margin: -8px -6px 7px -6px;
  border-radius: 3px 3px 0 0;
}
.kpi-lbl {
  font-size: 7px; text-transform: uppercase;
  letter-spacing: 0.5px; color: #6b7280;
  display: block; margin-bottom: 2px;
}
.kpi-val {
  font-size: 22px; font-weight: 700;
  color: #1a3a6b; line-height: 1; display: block;
}
.kpi-sub { font-size: 7px; color: #9ca3af; display: block; margin-top: 2px; }

/* ════════════════
   SECCIÓN MATERIAS
════════════════ */
.mats-wrap { padding: 0 18px 14px; }
.sec-hdr-table { width: 100%; border-collapse: collapse; margin-bottom: 9px; }
.sec-hdr-td-t {
  white-space: nowrap; padding: 0 10px;
  font-size: 7.5px; font-weight: 600; text-transform: uppercase;
  letter-spacing: 1.2px; color: #1a3a6b;
}

/* ── Tarjeta materia ── */
.mat-card {
  border: 1.5px solid #d1d5db; border-radius: 8px;
  overflow: hidden; margin-bottom: 8px;
  background: #fff; page-break-inside: avoid;
}

/* Top materia */
.mat-top { width: 100%; border-collapse: collapse; background: #eef4fc; border-bottom: 1px solid #d6e4f7; }
.mat-top td { vertical-align: middle; }
.mat-izq-td { padding: 8px 13px; }
.mat-nom {
  font-size: 11.5px; font-weight: 700; color: #1a3a6b;
  display: block; margin-bottom: 1px; line-height: 1.2;
}
.mat-doc { font-size: 8px; color: #6b7280; font-style: italic; display: block; margin-bottom: 3px; }
.hist-pill {
  display: inline-block; background: #d6e4f7; color: #1a3a6b;
  padding: 1px 6px; border-radius: 20px;
  font-size: 7px; font-weight: 500; margin-right: 3px;
}

.mat-der-td {
  width: 92px; border-left: 1px solid #d6e4f7;
  text-align: center; padding: 6px 8px; vertical-align: middle;
}
.nvl-badge {
  display: block;
  font-size: 7px; font-weight: 700; text-transform: uppercase;
  padding: 2px 0; border-radius: 20px;
  margin-bottom: 3px; text-align: center;
}
.nvl-bajo     { background: #fdf0f0; color: #9b1c1c; border: 1px solid #fca5a5; }
.nvl-basico   { background: #fef3e2; color: #b45309; border: 1px solid #fcd34d; }
.nvl-alto     { background: #eef4fc; color: #1a3a6b; border: 1px solid #d6e4f7; }
.nvl-superior { background: #e6f4ec; color: #1e6b45; border: 1px solid #6ee7b7; }

.mat-nota-g {
  font-size: 28px; font-weight: 700; color: #111827;
  line-height: 1; display: block;
}
.mat-nota-lbl { font-size: 6.5px; text-transform: uppercase; letter-spacing: 0.4px; color: #6b7280; }

/* Dimensiones */
.dims-table { width: 100%; border-collapse: collapse; border-bottom: 1px dashed #e5e7eb; }
.dim-td {
  padding: 6px 13px; width: 33.33%;
  border-right: 1px solid #e5e7eb; vertical-align: middle;
}
.dim-td:last-child { border-right: none; }
.dim-inner { border-collapse: collapse; }
.dim-inner td { vertical-align: middle; }
.dim-ico {
  width: 22px; height: 22px; border-radius: 5px;
  font-size: 9px; font-weight: 700;
  text-align: center; line-height: 22px;
  display: block;
}
.d-s { background: #dbeafe; color: #1e40af; }
.d-h { background: #d1fae5; color: #065f46; }
.d-p { background: #ede9fe; color: #4c1d95; }
.dim-lbl-td { padding-left: 7px; }
.dim-nm {
  font-size: 7px; text-transform: uppercase; letter-spacing: 0.4px;
  color: #6b7280; font-weight: 500; display: block;
}
.dim-nt { font-size: 14px; font-weight: 700; color: #111827; line-height: 1.1; display: block; }

/* Comentarios */
.coms-wrap { padding: 6px 13px 8px; background: #fafbfc; }
.com-table { width: 100%; border-collapse: collapse; border-top: 1px solid #f3f4f6; }
.com-table:first-child { border-top: none; }
.com-table td { font-size: 8.5px; color: #374151; padding: 2px 0; line-height: 1.5; vertical-align: top; }
.com-tag {
  display: inline-block; font-size: 7px; font-weight: 700; text-transform: uppercase;
  padding: 1px 5px; border-radius: 3px; white-space: nowrap;
}
.tag-saber { background: #dbeafe; color: #1e40af; }
.tag-hacer { background: #d1fae5; color: #065f46; }
.tag-ser   { background: #ede9fe; color: #4c1d95; }
.com-pre { color: #2d5da8; font-style: italic; font-weight: 500; white-space: nowrap; padding: 0 4px; }
.com-vacio { font-size: 8px; color: #9ca3af; font-style: italic; }

/* ════════════════
   PIE
════════════════ */
.pie-wrap { padding: 0 18px 14px; }

.escala-box {
  border: 1px solid #d1d5db; border-radius: 7px;
  padding: 7px 13px; background: #f9fafb; margin-bottom: 13px;
}
.escala-t {
  font-size: 7px; font-weight: 600; text-transform: uppercase;
  letter-spacing: 0.6px; color: #6b7280; margin-bottom: 5px; display: block;
}
.escala-table { border-collapse: collapse; }
.escala-dot {
  width: 10px; height: 10px; border-radius: 2px;
  display: inline-block; margin-right: 4px; vertical-align: middle;
}
.escala-txt { font-size: 8.5px; color: #374151; white-space: nowrap; }

.firmas-table { width: 100%; border-collapse: collapse; }
.firma-td { width: 33.33%; text-align: center; padding: 0 10px; }
.firma-linea { height: 34px; border-bottom: 1px solid #111827; display: block; margin-bottom: 4px; }
.firma-nom { font-size: 8.5px; font-weight: 600; color: #111827; display: block; }
.firma-car { font-size: 7.5px; color: #6b7280; display: block; }

/* Pie azul */
.nota-pie { background: #1a3a6b; padding: 5px 18px; }
.nota-pie-table { width: 100%; border-collapse: collapse; }
.nota-pie-table td { font-size: 7.5px; color: rgba(255,255,255,0.65); padding: 0; vertical-align: middle; }
.nota-pie-right { text-align: right; }

/* ════════════════
   MARCA DE AGUA
════════════════ */
.marca-agua {
  position: fixed; top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  width: 320px; height: 320px; object-fit: contain;
  opacity: 0.04; pointer-events: none; z-index: 0;
}

/* Botón web */
.btn-pdf-wrap { text-align: center; padding: 18px 0 28px; background: #f3f4f6; }
.btn-pdf {
  display: inline-block; background: #1a3a6b; color: #fff;
  padding: 10px 24px; border-radius: 7px; text-decoration: none;
  font-size: 12px; font-weight: 600;
}

/* ════════════════
   PRINT
════════════════ */
@page { size: A4; margin: 0; }
@media print {
  html, body { background: #fff !important; margin: 0 !important; padding: 0 !important; }
  .bol-wrap  { width: 100% !important; min-height: 100% !important; }
  .btn-pdf-wrap { display: none !important; }
  .mat-card  { page-break-inside: avoid; }
  * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
}
</style>

{{-- ✅ Marca de agua base64 --}}
@if(!empty($logoBase64))
  <img class="marca-agua" src="{{ $logoBase64 }}" alt="">
@endif

<div class="bol-wrap">

  <span class="franja-top"></span>
  <span class="franja-gold"></span>

  {{-- ══ CABECERA ══ --}}
  <table class="cab-table">
    <tr>
      <td class="cab-logo-td">
        <table style="width:62px;height:62px;background:#1a3a6b;border-radius:8px;" cellpadding="0" cellspacing="0">
          <tr><td style="text-align:center;vertical-align:middle;padding:3px;">
            @if(!empty($logoBase64))
              <img src="{{ $logoBase64 }}" alt="ITAF" style="width:56px;height:56px;object-fit:contain;">
            @else
              <span class="logo-fb">ITAF</span>
            @endif
          </td></tr>
        </table>
      </td>

      <td class="cab-inst-td">
        <span class="inst-nom">Instituto Técnico Agropecuario y Forestal</span>
        <span class="inst-sub">
          NIT: 800.032.991-3 &nbsp;·&nbsp; DANE: 319256002686 &nbsp;·&nbsp; Res. 2396 – Nov 27/2003<br>
          Vda. Villa al Mar Fondas · El Tambo, Cauca &nbsp;·&nbsp; Cel: 314 679 9431
        </span>
      </td>

      <td class="cab-meta-td">
        <span class="bol-badge">Boletín Académico</span><br>
        <span class="meta-fila">Año lectivo: <strong>{{ $yearLectivo ?? '2025' }}</strong></span>
        <span class="meta-fila">Calendario: <strong>A</strong></span>
        <span class="meta-fila">Periodo: <strong>{{ $period->name }}</strong></span>
        <span class="meta-fila">Estado: <strong>Matriculado</strong></span>
        <span class="meta-fila">Fecha: <strong>{{ now()->format('d/m/Y') }}</strong></span>
      </td>
    </tr>
  </table>

  {{-- ══ ESTUDIANTE ══ --}}
  <div class="est-wrap">
    <table class="est-table">
      <tr>
        <td style="width:54px;text-align:center;">
          <table style="width:40px;height:40px;background:rgba(255,255,255,0.15);border-radius:50%;margin:auto;" cellpadding="0" cellspacing="0">
            <tr><td style="text-align:center;vertical-align:middle;">
              <svg viewBox="0 0 24 24" width="20" height="20" style="fill:rgba(255,255,255,0.9);display:block;margin:auto;">
                <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
              </svg>
            </td></tr>
          </table>
        </td>

        <td style="vertical-align:middle;padding:11px 8px;">
          <span class="est-lbl">Nombre del Estudiante</span>
          <span class="est-nom">{{ strtoupper($student->full_name) }}</span>
        </td>

        <td class="est-sep">&nbsp;</td>

        <td class="est-dato-td">
          <span class="est-dlbl">Identificación</span>
          <span class="est-dval">{{ $student->identification_number }}</span>
        </td>

        <td class="est-sep">&nbsp;</td>

        <td class="est-dato-td">
          <span class="est-dlbl">Grado</span>
          <span class="est-dval">{{ $grade }}</span>
        </td>
      </tr>
    </table>
  </div>

  {{-- ══ KPIs ══ --}}
  <div class="kpis-wrap">
    <table class="kpis-table">
      <tr>
        <td class="kpi-td">
          <div class="kpi-box">
            <span class="kpi-bar"></span>
            <span class="kpi-lbl">Promedio General</span>
            <span class="kpi-val">{{ number_format($scores->avg('total'), 2) }}</span>
            <span class="kpi-sub">sobre 5.00</span>
          </div>
        </td>
        <td class="kpi-td">
          <div class="kpi-box">
            <span class="kpi-bar"></span>
            <span class="kpi-lbl">Puesto en Clase</span>
            <span class="kpi-val">{{ $puesto ?? '—' }}</span>
            <span class="kpi-sub">clasificación</span>
          </div>
        </td>
        <td class="kpi-td">
          <div class="kpi-box">
            <span class="kpi-bar"></span>
            <span class="kpi-lbl">Total Áreas</span>
            <span class="kpi-val">{{ $scores->count() }}</span>
            <span class="kpi-sub">materias evaluadas</span>
          </div>
        </td>
        <td class="kpi-td">
          <div class="kpi-box">
            <span class="kpi-bar"></span>
            <span class="kpi-lbl">Periodo</span>
            <span class="kpi-val" style="font-size:15px;">{{ $period->name }}</span>
            <span class="kpi-sub">{{ $yearLectivo ?? '2025' }}</span>
          </div>
        </td>
      </tr>
    </table>
  </div>

  {{-- ══ MATERIAS ══ --}}
  <div class="mats-wrap">

    <table class="sec-hdr-table">
      <tr>
        <td style="padding:0;">
          <div style="height:1.5px;background:linear-gradient(to right,#1a3a6b,transparent);"></div>
        </td>
        <td class="sec-hdr-td-t">Áreas y Valoraciones del Periodo</td>
        <td style="padding:0;">
          <div style="height:1.5px;background:linear-gradient(to left,transparent,#d6e4f7);"></div>
        </td>
      </tr>
    </table>

    @foreach($scores as $score)
    @php
      $subject = optional($score->teacherSubject->subject)->name ?? 'Sin materia';
      $teacher = optional(optional($score->teacherSubject->teacher)->user)->name ?? 'Sin docente';

      $comentarios = \App\Models\DimensionComment::where('teacher_subject_id', $score->teacher_subject_id)
          ->where('period_id', $period->id)
          ->get()->keyBy('dimension');

      $historial = $allScores[$score->teacher_subject_id] ?? collect();
      $nota      = $score->total;

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
    @endphp

    <div class="mat-card">

      <table class="mat-top">
        <tr>
          <td class="mat-izq-td">
            <span class="mat-nom">{{ $subject }}</span>
            <span class="mat-doc">Docente: {{ strtoupper($teacher) }}</span>
            @if($historial->isNotEmpty())
              <div style="margin-top:3px;">
                @foreach($historial as $h)
                  <span class="hist-pill">{{ $h->period->name }}: {{ number_format($h->total, 1) }}</span>
                @endforeach
              </div>
            @endif
          </td>
          <td class="mat-der-td">
            <span class="nvl-badge {{ $nivelClass }}">{{ $nivelNombre }}</span>
            <span class="mat-nota-g">{{ number_format($nota, 2) }}</span>
            <span class="mat-nota-lbl">Nota Final</span>
          </td>
        </tr>
      </table>

      <table class="dims-table">
        <tr>
          <td class="dim-td">
            <table class="dim-inner"><tr>
              <td><span class="dim-ico d-s">S</span></td>
              <td class="dim-lbl-td">
                <span class="dim-nm">Saber</span>
                <span class="dim-nt">{{ number_format($score->saber, 2) }}</span>
              </td>
            </tr></table>
          </td>
          <td class="dim-td">
            <table class="dim-inner"><tr>
              <td><span class="dim-ico d-h">H</span></td>
              <td class="dim-lbl-td">
                <span class="dim-nm">Hacer</span>
                <span class="dim-nt">{{ number_format($score->hacer, 2) }}</span>
              </td>
            </tr></table>
          </td>
          <td class="dim-td">
            <table class="dim-inner"><tr>
              <td><span class="dim-ico d-p">P</span></td>
              <td class="dim-lbl-td">
                <span class="dim-nm">Ser</span>
                <span class="dim-nt">{{ number_format($score->ser, 2) }}</span>
              </td>
            </tr></table>
          </td>
        </tr>
      </table>

      <div class="coms-wrap">
        @if($comentarios->isNotEmpty())
          @foreach(['saber','hacer','ser'] as $dim)
            @if(isset($comentarios[$dim]) && $comentarios[$dim]->comment)
              <table class="com-table"><tr>
                <td style="width:46px;white-space:nowrap;vertical-align:top;padding-right:3px;">
                  <span class="com-tag tag-{{ $dim }}">{{ ucfirst($dim) }}</span>
                </td>
                <td style="white-space:nowrap;width:74px;vertical-align:top;">
                  <span class="com-pre">{{ $prefijo }},</span>
                </td>
                <td style="vertical-align:top;">{{ $comentarios[$dim]->comment }}</td>
              </tr></table>
            @endif
          @endforeach
        @else
          <span class="com-vacio">Sin comentario registrado.</span>
        @endif
      </div>

    </div>
    @endforeach

  </div>

  {{-- ══ PIE ══ --}}
  <div class="pie-wrap">

    <div class="escala-box">
      <span class="escala-t">Escala de Valoración Nacional</span>
      <table class="escala-table">
        <tr>
          <td style="padding-right:14px;">
            <span class="escala-dot" style="background:#fca5a5;border:1px solid #ef4444;"></span>
            <span class="escala-txt"><strong>Bajo</strong> · 1.0 – 2.9</span>
          </td>
          <td style="padding-right:14px;">
            <span class="escala-dot" style="background:#fcd34d;border:1px solid #f59e0b;"></span>
            <span class="escala-txt"><strong>Básico</strong> · 3.0 – 3.9</span>
          </td>
          <td style="padding-right:14px;">
            <span class="escala-dot" style="background:#d6e4f7;border:1px solid #2d5da8;"></span>
            <span class="escala-txt"><strong>Alto</strong> · 4.0 – 4.5</span>
          </td>
          <td>
            <span class="escala-dot" style="background:#6ee7b7;border:1px solid #10b981;"></span>
            <span class="escala-txt"><strong>Superior</strong> · 4.6 – 5.0</span>
          </td>
        </tr>
      </table>
    </div>

    <table class="firmas-table">
      <tr>
        <td class="firma-td">
          <span class="firma-linea"></span>
          <span class="firma-nom">Director de Grupo</span>
          <span class="firma-car">Director(a)</span>
        </td>
        <td class="firma-td">
          <span class="firma-linea"></span>
          <span class="firma-nom">Rector</span>
          <span class="firma-car">Rector(a)</span>
        </td>
        <td class="firma-td">
          <span class="firma-linea"></span>
          <span class="firma-nom">Acudiente</span>
          <span class="firma-car">Padre / Madre / Acudiente</span>
        </td>
      </tr>
    </table>

  </div>

  <div class="nota-pie">
    <table class="nota-pie-table">
      <tr>
        <td>Instituto Técnico Agropecuario y Forestal · El Tambo, Cauca</td>
        <td class="nota-pie-right">Documento oficial · {{ now()->format('d/m/Y') }}</td>
      </tr>
    </table>
  </div>

  <span class="franja-gold"></span>
  <span class="franja-bot"></span>

</div>

@if(!isset($isPdf))
<div class="btn-pdf-wrap">
  <a class="btn-pdf" href="{{ route('admin.boletin.pdf', [$student->id, $period->id]) }}">
    ⬇ Descargar PDF
  </a>
</div>
@endif

@endsection