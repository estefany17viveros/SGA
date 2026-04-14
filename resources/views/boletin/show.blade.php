@extends('layouts.app')

@section('content')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Source+Serif+4:ital,wght@0,300;0,600;1,300&family=DM+Sans:wght@400;500;600&display=swap');

  :root {
    --verde:       #3c76ea;
    --verde-suave: #e8e8f2;
    --verde-medio: #9eb0d8;
    --negro:       #111;
    --gris-texto:  #444;
    --gris-borde:  #ccc;
    --fondo:       #ffffff00;
    --blanco:      #ffffff;
    --radio:       6px;
  }

  * { box-sizing: border-box; margin: 0; padding: 0; }

  /* ── CONTENEDOR PRINCIPAL ── */
  .boletin {
    font-family: 'DM Sans', sans-serif;
    font-size: 11px;
    color: var(--negro);
    background: var(--fondo);
    padding: 28px 24px;
    max-width: 820px;
    margin: 0 auto;
    line-height: 1.5;
  }

  /* ── CABECERA ── */
  .cab {
    display: grid;
    grid-template-columns: 100px 1fr 200px;
    gap: 0;
    border: 1.5px solid var(--verde);
    border-radius: var(--radio);
    overflow: hidden;
    background: var(--blanco);
    margin-bottom: 12px;
  }
  .cab-logo {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 14px;
  }
  .cab-logo img {
  width: 180px; /* puedes dejarlo más grande */
  height: auto;
  object-fit: contain;
  border: none; /* quitamos borde */
  border-radius: 0; /* 🔥 esto elimina el círculo */
}
  .cab-logo-fallback {
    width: 70px; height: 70px;
    border-radius: 50%;
    border: 2px solid rgba(255,255,255,0.5);
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; font-weight: 600; color: #fff;
  }
  .cab-inst {
    padding: 14px 16px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    border-left: 1px solid var(--verde-medio);
    border-right: 1px solid var(--verde-medio);
  }
  .cab-inst-nombre {
    font-family: 'Source Serif 4', serif;
    font-size: 14px;
    font-weight: 600;
    color: var(--verde);
    letter-spacing: 0.2px;
    margin-bottom: 5px;
  }
  .cab-inst-sub {
    font-size: 9.5px;
    color: var(--gris-texto);
    line-height: 1.8;
  }
  .cab-meta {
    padding: 14px 14px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 3px;
    background: var(--verde-suave);
  }
  .cab-meta-titulo {
    font-family: 'Source Serif 4', serif;
    font-size: 13px;
    font-weight: 600;
    color: var(--verde);
    margin-bottom: 6px;
    border-bottom: 1px solid var(--verde-medio);
    padding-bottom: 4px;
  }
  .cab-meta-fila {
    font-size: 10px;
    color: var(--gris-texto);
  }
  .cab-meta-fila strong {
    color: var(--negro);
    font-weight: 500;
  }

  /* ── TARJETA ESTUDIANTE ── */
  .card-estudiante {
    background: var(--blanco);
    border: 1px solid var(--gris-borde);
    border-radius: var(--radio);
    padding: 10px 16px;
    display: grid;
    grid-template-columns: 1fr 200px 120px;
    gap: 8px;
    align-items: center;
    margin-bottom: 8px;
  }
  .card-estudiante .campo { font-size: 10.5px; color: var(--gris-texto); }
  .card-estudiante .valor { font-size: 12px; font-weight: 600; color: var(--negro); margin-top: 2px; }

  /* ── RESUMEN PROMEDIO ── */
  .resumen {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 8px;
    margin-bottom: 14px;
  }
  .resumen-item {
    background: var(--blanco);
    border: 1px solid var(--gris-borde);
    border-radius: var(--radio);
    padding: 10px 12px;
    text-align: center;
  }
  .resumen-item .r-label {
    font-size: 9px;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: var(--gris-texto);
    margin-bottom: 4px;
  }
  .resumen-item .r-valor {
    font-family: 'Source Serif 4', serif;
    font-size: 20px;
    font-weight: 600;
    color: var(--verde);
  }

  /* ── TÍTULO SECCIÓN ── */
  .seccion-titulo {
    font-size: 9px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--blanco);
    background: var(--verde);
    padding: 5px 12px;
    border-radius: var(--radio) var(--radio) 0 0;
  }

  /* ── BLOQUES MATERIA ── */
  .materias-wrap {
    border: 1px solid var(--gris-borde);
    border-radius: 0 0 var(--radio) var(--radio);
    overflow: hidden;
    margin-bottom: 12px;
    background: var(--blanco);
  }
  .materia {
    border-bottom: 1px solid #e8e8e8;
  }
  .materia:last-child { border-bottom: none; }

  .mat-header {
    display: grid;
    grid-template-columns: 1fr 110px;
    background: var(--verde-suave);
    border-bottom: 1px solid var(--verde-medio);
  }
  .mat-header-izq {
    padding: 8px 12px;
  }
  .mat-nombre {
    font-size: 11.5px;
    font-weight: 600;
    color: var(--verde);
  }
  .mat-docente {
    font-size: 9.5px;
    color: var(--gris-texto);
    margin-top: 2px;
    font-style: italic;
  }
  .mat-historial {
    font-size: 9px;
    color: #666;
    margin-top: 3px;
  }
  .mat-header-der {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 8px;
    border-left: 1px solid var(--verde-medio);
    text-align: center;
    background: var(--blanco);
  }
  .mat-badge {
    font-size: 8.5px;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 20px;
    border: 1px solid var(--verde);
    color: var(--verde);
    background: var(--verde-suave);
    margin-bottom: 4px;
    letter-spacing: 0.3px;
  }
  .mat-nota {
    font-family: 'Source Serif 4', serif;
    font-size: 22px;
    font-weight: 600;
    color: var(--negro);
    line-height: 1;
  }

  /* ── NOTAS DIMENSIONES ── */
  .mat-dims {
    display: flex;
    gap: 0;
    padding: 7px 12px;
    background: #fafafa;
    border-bottom: 1px solid #efefef;
  }
  .dim-chip {
    font-size: 10px;
    padding: 3px 12px 3px 0;
    border-right: 1px solid #e0e0e0;
    margin-right: 12px;
    color: var(--gris-texto);
  }
  .dim-chip:last-child { border-right: none; }
  .dim-chip strong { color: var(--negro); font-weight: 600; }

  /* ── COMENTARIOS ── */
  .mat-comentarios {
    padding: 8px 12px 10px;
  }
  .com-titulo {
    font-size: 9px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: var(--gris-texto);
    margin-bottom: 6px;
  }
  .com-fila {
    display: flex;
    align-items: baseline;
    gap: 6px;
    padding: 3px 0;
    border-top: 1px dashed #e8e8e8;
    font-size: 10px;
    line-height: 1.55;
    color: #333;
  }
  .com-fila:first-of-type { border-top: none; }
  .com-prefijo {
    font-style: italic;
    color: var(--verde);
    white-space: nowrap;
    font-weight: 500;
  }
  .com-vacio {
    font-size: 10px;
    color: #999;
    font-style: italic;
  }

  /* ── PIE ── */
  .pie {
    background: var(--blanco);
    border: 1px solid var(--gris-borde);
    border-radius: var(--radio);
    padding: 10px 14px;
    font-size: 10px;
    color: var(--gris-texto);
    line-height: 1.8;
    margin-bottom: 32px;
  }
  .pie strong { color: var(--negro); }
  .nivel-tag {
    display: inline-block;
    padding: 1px 7px;
    border-radius: 20px;
    font-size: 9px;
    font-weight: 600;
    margin: 0 2px;
  }
  .nivel-bajo    { background: #fdecea; color: #b71c1c; border: 1px solid #f5a5a5; }
  .nivel-basico  { background: #fff8e1; color: #e65100; border: 1px solid #ffd180; }
  .nivel-alto    { background: #e3f2fd; color: #0d47a1; border: 1px solid #90caf9; }
  .nivel-superior{ background: var(--verde-suave); color: var(--verde); border: 1px solid var(--verde-medio); }

  /* ── FIRMAS ── */
  .firmas {
    display: flex;
    justify-content: space-around;
    margin-top: 8px;
  }
  .firma-bloque {
    text-align: center;
    font-size: 10px;
    color: var(--gris-texto);
  }
  .firma-linea {
    width: 160px;
    border-top: 1px solid var(--negro);
    margin: 0 auto 5px;
  }

  /* ── MARCA DE AGUA ── */
  .marca-agua {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 380px;
    height: 380px;
    object-fit: contain;
    opacity: 0.035;
    pointer-events: none;
    z-index: 0;
  }

  @media print {
    .boletin { padding: 12px; max-width: 100%; background: #fff; }
    .marca-agua { position: absolute; }
  }
</style>

{{-- MARCA DE AGUA --}}
@if(file_exists(public_path('images/logo-itaf.jpg')))
  <img class="marca-agua" src="{{ asset('images/logo-itaf.jpg') }}" alt="">
@endif

<div class="boletin">

  {{-- ── CABECERA ── --}}
  <div class="cab">
    <div class="cab-logo">
      @if(file_exists(public_path('images/logo-itaf.jpg')))
        <img src="{{ asset('images/logo-itaf.jpg') }}" alt="Logo ITAF">
      @else
        <div class="cab-logo-fallback">ITAF</div>
      @endif
    </div>

    <div class="cab-inst">
      <div class="cab-inst-nombre">Instituto Técnico Agropecuario y Forestal</div>
      <div class="cab-inst-sub">
        NIT: 800.032.991-3 &nbsp;·&nbsp; DANE: 319256002686<br>
        Res. 2396 · Nov 27 de 2003 &nbsp;·&nbsp; Vereda Villa al Mar Fondas<br>
        El Tambo – Cauca &nbsp;·&nbsp; Cel: 314 679 9431
      </div>
    </div>

    <div class="cab-meta">
      <div class="cab-meta-titulo">Boletín Académico</div>
      <div class="cab-meta-fila">Año: <strong>{{ $yearLectivo ?? '2025' }}</strong></div>
      <div class="cab-meta-fila">Calendario: <strong>A</strong></div>
      <div class="cab-meta-fila">Periodo: <strong>{{ $period->name }}</strong></div>
      <div class="cab-meta-fila">Estado: <strong>Matriculado</strong></div>
      <div class="cab-meta-fila">Fecha: <strong>{{ now()->translatedFormat('d/m/Y') }}</strong></div>
    </div>
  </div>

  {{-- ── DATOS ESTUDIANTE ── --}}
  <div class="card-estudiante">
    <div>
      <div class="campo">Estudiante</div>
      <div class="valor">{{ strtoupper($student->full_name) }}</div>
    </div>
    <div>
      <div class="campo">Identificación</div>
      <div class="valor">{{ $student->identification_number }}</div>
    </div>
    <div>
      <div class="campo">Grado</div>
      <div class="valor">{{ $grade }}</div>
    </div>
  </div>

  {{-- ── RESUMEN ── --}}
  <div class="resumen">
    <div class="resumen-item">
      <div class="r-label">Promedio</div>
      <div class="r-valor">{{ round($scores->avg('total'), 2) }}</div>
    </div>
    <div class="resumen-item">
      <div class="r-label">Ponderado</div>
      <div class="r-valor">{{ number_format($scores->avg('total'), 3) }}</div>
    </div>
    <div class="resumen-item">
      <div class="r-label">Puesto</div>
      <div class="r-valor">{{ $puesto ?? '—' }}</div>
    </div>
    <div class="resumen-item">
      <div class="r-label">Materias</div>
      <div class="r-valor">{{ $scores->count() }}</div>
    </div>
  </div>

  {{-- ── MATERIAS ── --}}
  <div class="seccion-titulo">Áreas y valoraciones</div>
  <div class="materias-wrap">
    @foreach($scores as $score)
    @php
      $subject  = optional($score->teacherSubject->subject)->name ?? 'Sin materia';
      $teacher  = optional(optional($score->teacherSubject->teacher)->user)->name ?? 'Sin docente';

      $comentarios = \App\Models\DimensionComment::where('teacher_subject_id', $score->teacher_subject_id)
          ->where('period_id', $period->id)
          ->get()
          ->keyBy('dimension');

      $historial = $allScores[$score->teacher_subject_id] ?? collect();

      $nota = $score->total;
      if ($nota >= 4.6)      $prefijo = 'Siempre';
      elseif ($nota >= 4.0)  $prefijo = 'Casi siempre';
      elseif ($nota >= 3.0)  $prefijo = 'Algunas veces';
      else                   $prefijo = 'Con dificultad';
    @endphp

    <div class="materia">

      <div class="mat-header">
        <div class="mat-header-izq">
          <div class="mat-nombre">{{ $subject }}</div>
          <div class="mat-docente">{{ strtoupper($teacher) }}</div>
          @if($historial->isNotEmpty())
            <div class="mat-historial">
              @foreach($historial as $h)
                {{ $h->period->name }}: <strong>{{ number_format($h->total, 1) }}</strong>@if(!$loop->last) &nbsp;·&nbsp; @endif
              @endforeach
            </div>
          @endif
        </div>
        <div class="mat-header-der">
          <span class="mat-badge">{{ $score->nivel_nombre }}</span>
          <div class="mat-nota">{{ $score->total }}</div>
        </div>
      </div>

      <div class="mat-dims">
        <div class="dim-chip">Saber <strong>{{ $score->saber }}</strong></div>
        <div class="dim-chip">Hacer <strong>{{ $score->hacer }}</strong></div>
        <div class="dim-chip">Ser <strong>{{ $score->ser }}</strong></div>
        <div class="dim-chip">Total <strong>{{ $score->total }}</strong></div>
      </div>

      <div class="mat-comentarios">
        @if($comentarios->isNotEmpty())
          <div class="com-titulo">Observaciones — {{ $score->nivel_nombre }}</div>
          @foreach(['saber', 'hacer', 'ser'] as $dim)
            @if(isset($comentarios[$dim]) && $comentarios[$dim]->comment)
              <div class="com-fila">
                <span class="com-prefijo">{{ $prefijo }},</span>
                {{ $comentarios[$dim]->comment }}
              </div>
            @endif
          @endforeach
        @else
          <span class="com-vacio">Sin comentario registrado.</span>
        @endif
      </div>

    </div>
    @endforeach
  </div>

  {{-- ── PIE ── --}}
  <div class="pie">
    <strong>Escala de valoración:</strong>
    <span class="nivel-tag nivel-bajo">Bajo 1.0–2.9</span>
    <span class="nivel-tag nivel-basico">Básico 3.0–3.9</span>
    <span class="nivel-tag nivel-alto">Alto 4.0–4.5</span>
    <span class="nivel-tag nivel-superior">Superior 4.6–5.0</span><br>
    Las valoraciones de reprobación construyen el plan de recuperación de los periodos siguientes.
  </div>

  {{-- ── FIRMAS ── --}}
  <div class="firmas">
    <div class="firma-bloque">
      <div class="firma-linea"></div>
      Rector
    </div>
    <div class="firma-bloque">
      <div class="firma-linea"></div>
      Director de Grupo
    </div>
  </div>
<a href="{{ route('teacher.boletin.pdf', [$student->id, $period->id]) }}"
   style="background:#1e3a8a;color:white;padding:6px 12px;text-decoration:none;">
   Descargar PDF
</a>
</div>
@endsection