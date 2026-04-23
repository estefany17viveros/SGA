
<?php
    $allPeriods = \App\Models\Period::where('academic_year_id', $period->academic_year_id)
        ->orderBy('id')
        ->pluck('id')
        ->toArray();

    $lastPeriodId = end($allPeriods);
    $isLastPeriod = $period->id == $lastPeriodId;
?>


<?php if(!empty($logoBase64)): ?>
    <img class="marca-agua" src="<?php echo e($logoBase64); ?>" alt="">
<?php endif; ?>

<div class="bol-wrap">

    <span class="franja-top"></span>
    <span class="franja-gold"></span>

    
    <table class="cab-table">
        <tr>
            <td class="cab-logo-td">
                <table style="width:62px;height:62px;background:#1a3a6b;border-radius:8px;" cellpadding="0" cellspacing="0">
                    <tr><td style="text-align:center;vertical-align:middle;padding:3px;">
                        <?php if(!empty($logoBase64)): ?>
                            <img src="<?php echo e($logoBase64); ?>" alt="ITAF" style="width:56px;height:56px;object-fit:contain;">
                        <?php else: ?>
                            <span class="logo-fb">ITAF</span>
                        <?php endif; ?>
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
                <span class="meta-fila">Año lectivo: <strong><?php echo e($yearLectivo ?? '2025'); ?></strong></span>
                <span class="meta-fila">Calendario: <strong>A</strong></span>
                <span class="meta-fila">Periodo: <strong><?php echo e($period->name); ?></strong></span>
                <span class="meta-fila">Estado: <strong>Matriculado</strong></span>
                <span class="meta-fila">Fecha: <strong><?php echo e(now()->format('d/m/Y')); ?></strong></span>
            </td>
        </tr>
    </table>

    
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
                    <span class="est-nom"><?php echo e(strtoupper($student->full_name)); ?></span>
                </td>

                <td class="est-sep">&nbsp;</td>

                <td class="est-dato-td">
                    <span class="est-dlbl">Identificación</span>
                    <span class="est-dval"><?php echo e($student->identification_number); ?></span>
                </td>

                <td class="est-sep">&nbsp;</td>

                <td class="est-dato-td">
                    <span class="est-dlbl">Grado</span>
                    <span class="est-dval"><?php echo e($grade); ?></span>
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
                        <span class="kpi-lbl">Promedio General</span>
                        <span class="kpi-val"><?php echo e(number_format($scores->avg('total'), 2)); ?></span>
                        <span class="kpi-sub">sobre 5.00</span>
                    </div>
                </td>
                <td class="kpi-td">
                    <div class="kpi-box">
                        <span class="kpi-bar"></span>
                        <span class="kpi-lbl">Puesto en Clase</span>
                        <span class="kpi-val"><?php echo e($puesto ?? '—'); ?></span>
                        <span class="kpi-sub">clasificación</span>
                    </div>
                </td>
                <td class="kpi-td">
                    <div class="kpi-box">
                        <span class="kpi-bar"></span>
                        <span class="kpi-lbl">Total Áreas</span>
                        <span class="kpi-val"><?php echo e($scores->count()); ?></span>
                        <span class="kpi-sub">materias evaluadas</span>
                    </div>
                </td>
                <td class="kpi-td">
                    <div class="kpi-box">
                        <span class="kpi-bar"></span>
                        <span class="kpi-lbl">Periodo</span>
                        <span class="kpi-val" style="font-size:15px;"><?php echo e($period->name); ?></span>
                        <span class="kpi-sub"><?php echo e($yearLectivo ?? '2025'); ?></span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    
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

        <?php $__currentLoopData = $scores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $score): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $subject = optional($score->teacherSubject->subject)->name ?? 'Sin materia';
            $teacher = optional(optional($score->teacherSubject->teacher)->user)->name ?? 'Sin docente';

            $comentarios = \App\Models\DimensionComment::where('teacher_subject_id', $score->teacher_subject_id)
                ->where('period_id', $period->id)
                ->get()
                ->keyBy('dimension');

            $historial = $allScores[$score->teacher_subject_id] ?? collect();

            if ($isLastPeriod) {
                $total = $historial->whereNotNull('total')->sum('total');
                $count = $historial->whereNotNull('total')->count();
                $nota  = $count > 0 ? round($total / $count, 2) : 0;
                $saber = round($historial->avg('saber'), 2);
                $hacer = round($historial->avg('hacer'), 2);
                $ser   = round($historial->avg('ser'), 2);
            } else {
                $nota  = $score->total;
                $saber = $score->saber;
                $hacer = $score->hacer;
                $ser   = $score->ser;
            }

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
                        <span class="mat-nom"><?php echo e($subject); ?></span>
                        <span class="mat-doc">Docente: <?php echo e(strtoupper($teacher)); ?></span>
                        <?php if($historial->isNotEmpty()): ?>
                            <div style="margin-top:3px;">
                                <?php $__currentLoopData = $historial; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="hist-pill"><?php echo e($h->period->name); ?>: <?php echo e(number_format(floor($h->total * 100) / 100, 2, '.', '')); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="mat-der-td">
                        <span class="nvl-badge <?php echo e($nivelClass); ?>"><?php echo e($nivelNombre); ?></span>
                        <span class="mat-nota-g"><?php echo e(number_format($nota, 2)); ?></span>
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
                                <span class="dim-nt"><?php echo e(number_format($saber, 2)); ?></span>
                            </td>
                        </tr></table>
                    </td>
                    <td class="dim-td">
                        <table class="dim-inner"><tr>
                            <td><span class="dim-ico d-h">H</span></td>
                            <td class="dim-lbl-td">
                                <span class="dim-nm">Hacer</span>
                                <span class="dim-nt"><?php echo e(number_format($hacer, 2)); ?></span>
                            </td>
                        </tr></table>
                    </td>
                    <td class="dim-td">
                        <table class="dim-inner"><tr>
                            <td><span class="dim-ico d-p">P</span></td>
                            <td class="dim-lbl-td">
                                <span class="dim-nm">Ser</span>
                                <span class="dim-nt"><?php echo e(number_format($ser, 2)); ?></span>
                            </td>
                        </tr></table>
                    </td>
                </tr>
            </table>

            <div class="coms-wrap">
                <?php if($comentarios->isNotEmpty()): ?>
                    <?php $__currentLoopData = ['saber','hacer','ser']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dim): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(isset($comentarios[$dim]) && $comentarios[$dim]->comment): ?>
                            <table class="com-table"><tr>
                                <td style="width:46px;white-space:nowrap;vertical-align:top;padding-right:3px;">
                                    <span class="com-tag tag-<?php echo e($dim); ?>"><?php echo e(ucfirst($dim)); ?></span>
                                </td>
                                <td style="white-space:nowrap;width:74px;vertical-align:top;">
                                    <span class="com-pre"><?php echo e($prefijo); ?>,</span>
                                </td>
                                <td style="vertical-align:top;"><?php echo e($comentarios[$dim]->comment); ?></td>
                            </tr></table>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <span class="com-vacio">Definitiva en la materia.</span>
                <?php endif; ?>
            </div>

        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>

    
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
                <td class="nota-pie-right">Documento oficial · <?php echo e(now()->format('d/m/Y')); ?></td>
            </tr>
        </table>
    </div>

    <span class="franja-gold"></span>
    <span class="franja-bot"></span>

</div><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/boletin/boletin.blade.php ENDPATH**/ ?>