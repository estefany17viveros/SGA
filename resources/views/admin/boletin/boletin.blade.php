{{-- =========================================================
    PARTIAL: admin/boletin/_boletin.blade.php
========================================================= --}}

@php
    $allPeriods = \App\Models\Period::where('academic_year_id', $period->academic_year_id)
        ->orderBy('id')
        ->pluck('id')
        ->toArray();

    $lastPeriodId = end($allPeriods);

    $isLastPeriod = $period->id == $lastPeriodId;

    if (!function_exists('truncar1')) {
        function truncar1($valor)
        {
            return number_format(floor(((float)$valor) * 10) / 10, 1, '.', '');
        }
    }

    if (!function_exists('truncar2')) {
        function truncar2($valor)
        {
            return number_format(floor(((float)$valor) * 100) / 100, 2, '.', '');
        }
    }

  $promedioGeneralFloat = (float) ($disciplineNote ?? $promedioAcumulado ?? 0);
     $discPrefijo = match (true) {
        $promedioGeneralFloat >= 4.6 => 'Siempre',
        $promedioGeneralFloat >= 4.0 => 'Casi siempre',
        $promedioGeneralFloat >= 3.0 => 'Algunas veces',
        default => 'Con dificultad',
    };

    $discNivelClass = match (true) {
        $promedioGeneralFloat >= 4.6 => 'nvl-superior',
        $promedioGeneralFloat >= 4.0 => 'nvl-alto',
        $promedioGeneralFloat >= 3.0 => 'nvl-basico',
        default => 'nvl-bajo',
    };

    $discNivelNombre = match (true) {
        $promedioGeneralFloat >= 4.6 => 'Superior',
        $promedioGeneralFloat >= 4.0 => 'Alto',
        $promedioGeneralFloat >= 3.0 => 'Básico',
        default => 'Bajo',
    };
@endphp

@if(!empty($logoBase64))
    <img class="marca-agua" src="{{ $logoBase64 }}" alt="">
@endif

<div class="bol-wrap">

    <span class="franja-top"></span>
    <span class="franja-gold"></span>

    {{-- ================= CABECERA ================= --}}
    <table class="cab-table">
        <tr>

            <td class="cab-logo-td">

                @if(!empty($logoBase64))
                    <img
                        src="{{ $logoBase64 }}"
                        alt="Logo"
                        style="
                            width:64px;
                            height:64px;
                            object-fit:contain;
                            display:block;
                            background: transparent !important;
                            mix-blend-mode: multiply;
                        "
                    >
                @else
                    <span class="logo-fb">ITAF</span>
                @endif

            </td>

            <td class="cab-inst-td">

                <span class="inst-nom">
                    Instituto Técnico Agropecuario y Forestal
                </span>

                <span class="inst-sub">
                    NIT: 800.032.991-3 ·
                    DANE: 319256002686 ·
                    Res. 2396 – Nov 27/2003
                    <br>
                    Vda. Villa al Mar Fondas ·
                    El Tambo, Cauca ·
                    Cel: 314 679 9431
                </span>

            </td>

            <td class="cab-meta-td">

                <span class="bol-badge">
                    Boletín Académico
                </span>

                <br>

                <span class="meta-fila">
                    Año lectivo:
                    <strong>{{ $yearLectivo ?? '2025' }}</strong>
                </span>

                <span class="meta-fila">
                    Calendario:
                    <strong>A</strong>
                </span>

                <span class="meta-fila">
                    Trimestre:
                    <strong>{{ $period->name }}</strong>
                </span>

                <span class="meta-fila">
                    Estado:
                    <strong>Matriculado</strong>
                </span>

                <span class="meta-fila">
                    Fecha:
                    <strong>{{ now()->format('d/m/Y') }}</strong>
                </span>

            </td>

        </tr>
    </table>

    {{-- ================= ESTUDIANTE ================= --}}
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

                                <svg
                                    viewBox="0 0 24 24"
                                    width="20"
                                    height="20"
                                    style="
                                        fill:rgba(255,255,255,0.9);
                                        display:block;
                                        margin:auto;
                                    "
                                >
                                    <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                                </svg>

                            </td>
                        </tr>
                    </table>

                </td>

                <td style="vertical-align:middle;padding:11px 8px;">

                    <span class="est-lbl">
                        Nombre del Estudiante
                    </span>

                    <span class="est-nom">
                        {{ strtoupper($student->full_name) }}
                    </span>

                </td>

                <td class="est-sep">&nbsp;</td>

                <td class="est-dato-td">

                    <span class="est-dlbl">
                        Identificación
                    </span>

                    <span class="est-dval">
                        {{ $student->identification_number }}
                    </span>

                </td>

                <td class="est-sep">&nbsp;</td>

                <td class="est-dato-td">

                    <span class="est-dlbl">
                        Grado
                    </span>

                    <span class="est-dval">
                        {{ $grade }}
                    </span>

                </td>

            </tr>

        </table>

    </div>

    {{-- ================= KPIS ================= --}}
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
                            {{ truncar1($promedioAcumulado) }}
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
                            {{ $puesto ?? '—' }}
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
                            {{ $scores->count() }}
                        </span>

                        <span class="kpi-sub">
                            Asignaturas evaluadas
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
                            {{ $period->name }}
                        </span>

                        <span class="kpi-sub">
                            {{ $yearLectivo ?? '2025' }}
                        </span>

                    </div>

                </td>

            </tr>

        </table>

    </div>

    {{-- ================= MATERIAS ================= --}}
    <div class="mats-wrap">

        @foreach($scores as $score)

            @php

                $subject = optional($score->teacherSubject->subject)->name ?? 'Sin Asignatura';

                $teacher = optional(
                    optional($score->teacherSubject->teacher)->user
                )->name ?? 'Sin docente';

                $horas =
                    $score->teacherSubject->weekly_hours
                    ?? $score->teacherSubject->hours_per_week
                    ?? null;

                $comentarios = \App\Models\DimensionComment::where(
                        'teacher_subject_id',
                        $score->teacher_subject_id
                    )
                    ->where('period_id', $period->id)
                    ->get()
                    ->keyBy('dimension');

                $historial =
                    $allScores[$score->teacher_subject_id]
                    ?? collect();

                if ($isLastPeriod) {

                    $histSinNull = $historial->whereNotNull('total');

                    $total = 0;

                    foreach ($histSinNull as $item) {

                        $notaIndividual =
                            floor(((float)$item->total) * 10) / 10;

                        $total += $notaIndividual;
                    }

                    $cantidad = $histSinNull->count();

                    $nota = $cantidad > 0
                        ? $total / $cantidad
                        : 0;

                    $nota = floor($nota * 10) / 10;

                } else {

                    $nota = $score->total ?? 0;
                }

                $saber = $score->saber ?? 0;
                $hacer = $score->hacer ?? 0;
                $ser   = $score->ser ?? 0;

                $notaFmt  = truncar1($nota);
                $saberFmt = truncar1($saber);
                $hacerFmt = truncar1($hacer);
                $serFmt   = truncar1($ser);

                $prefijo = match (true) {
                    $nota >= 4.6 => 'Siempre',
                    $nota >= 4.0 => 'Casi siempre',
                    $nota >= 3.0 => 'Algunas veces',
                    default => 'Con dificultad',
                };

                $nivelClass = match (true) {
                    $nota >= 4.6 => 'nvl-superior',
                    $nota >= 4.0 => 'nvl-alto',
                    $nota >= 3.0 => 'nvl-basico',
                    default => 'nvl-bajo',
                };

                $nivelNombre = match (true) {
                    $nota >= 4.6 => 'Superior',
                    $nota >= 4.0 => 'Alto',
                    $nota >= 3.0 => 'Básico',
                    default => 'Bajo',
                };

            @endphp

            <div class="mat-card">

                <table class="mat-top">

                    <tr>

                        <td class="mat-izq-td">

                            <span class="mat-nom">
                                {{ $subject }}
                            </span>

                            <span class="mat-doc">

                                Docente:
                                {{ strtoupper($teacher) }}

                                @if($horas)

                                    <span class="mat-horas">
                                        · {{ $horas }} h/sem
                                    </span>

                                @endif

                            </span>

                            @if($historial->isNotEmpty())

                                <div style="margin-top:4px;">

                                    @foreach($historial as $h)

                                        <span class="hist-pill">
                                            {{ $h->period->name }}
                                            :
                                            {{ truncar1($h->total) }}
                                        </span>

                                    @endforeach

                                </div>

                            @endif

                        </td>

                        <td class="mat-der-td">

                            <span class="nvl-badge {{ $nivelClass }}">
                                {{ $nivelNombre }}
                            </span>

                            <span class="mat-nota-g">
                                {{ $notaFmt }}
                            </span>

                            <span class="mat-nota-lbl">
                                Nota Final
                            </span>

                        </td>

                    </tr>

                </table>

                {{-- DIMENSIONES --}}
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
                                            {{ $saberFmt }}
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
                                            {{ $hacerFmt }}
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
                                            {{ $serFmt }}
                                        </span>

                                    </td>

                                </tr>
                            </table>

                        </td>

                    </tr>

                </table>

                {{-- COMENTARIOS --}}
                <div class="coms-wrap">

                    @if($comentarios->isNotEmpty())

                        @foreach(['saber','hacer','ser'] as $dim)

                            @if(
                                isset($comentarios[$dim]) &&
                                $comentarios[$dim]->comment
                            )

                                <table class="com-table">

                                    <tr>

                                        <td
                                            style="
                                                width:46px;
                                                vertical-align:top;
                                                padding-right:4px;
                                            "
                                        >

                                            <span class="com-tag tag-{{ $dim }}">
                                                {{ ucfirst($dim) }}
                                            </span>

                                        </td>

                                        <td style="vertical-align:top;">

                                            <span class="com-pre">
                                                {{ $prefijo }},
                                            </span>

                                            {{ $comentarios[$dim]->comment }}

                                        </td>

                                    </tr>

                                </table>

                            @endif

                        @endforeach

                    @else

                        <span class="com-vacio">
                            Definitiva en la asignatura.
                        </span>

                    @endif

                </div>

            </div>

        @endforeach

        {{-- ================= DISCIPLINA ================= --}}
        @if(!empty($disciplineComment) && $disciplineComment->comment)

            <div class="mat-card mat-card-disciplina">

                <table class="mat-top">

                    <tr>

                        <td class="mat-izq-td">

                            <span
                                class="mat-nom"
                                style="color:#92400e;"
                            >
                                Disciplina y Comportamiento
                            </span>

                            <span class="mat-doc">

                                Director(a) de Grado:
                                {{ strtoupper($directorName ?? 'Director') }}

                            </span>

                        </td>

                        <td class="mat-der-td">

                        <span class="nvl-badge {{ $discNivelClass }}">
                            {{ $discNivelNombre }}
                        </span>

                        <span class="mat-nota-g">
                            {{ truncar1($disciplineNote ?? 0) }}
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

                            <td style="vertical-align:top;">

                                <span class="com-pre">
                                    {{ $discPrefijo }},
                                </span>

                                {{ $disciplineComment->comment }}

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

        @endif

    </div>

</div>

<style>

.marca-agua{
    opacity:0.05;
    position:absolute;
    top:35%;
    left:18%;
    width:420px;
    background:transparent !important;
    mix-blend-mode:multiply;
}

.mat-horas{
    font-size:9px;
    font-weight:700;
    color:#315ea8;
    background:#eaf2ff;
    padding:2px 5px;
    border-radius:4px;
}

.hist-pill{
    display:inline-block;
    padding:2px 5px;
    border-radius:4px;
    background:#edf4ff;
    color:#315ea8;
    font-size:8px;
    margin-right:3px;
    margin-top:2px;
}

.mat-card-disciplina{
    border-left:4px solid #d97706;
    background:#fffbeb;
}

</style>