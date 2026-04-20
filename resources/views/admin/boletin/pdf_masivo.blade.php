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
            padding: 20px;
        }

        /* 🔥 IMPORTANTE PARA DOMPDF */
        .page:last-child {
            page-break-after: auto;
        }
    </style>
</head>
<body>

@foreach($boletines as $data)

    @php
        $student   = $data['student'] ?? null;
        $scores    = $data['scores'] ?? collect();
        $allScores = $data['allScores'] ?? collect();
        $puesto    = $data['puesto'] ?? '—'; // 🔥 evita error
        $grade     = $data['grade'] ?? 'N/A';
    @endphp

    <div class="page">

        {{-- 🔥 IMPORTANTE --}}
        {{-- ESTA VISTA ES TU DISEÑO ORIGINAL --}}
        {{-- SOLO ASEGÚRATE QUE NO TENGA BOTÓN PDF --}}

      @include('admin.boletin.show', [
    'student' => $student,
    'scores' => $scores,
    'allScores' => $allScores,
    'puesto' => $puesto,
    'grade' => $grade,
    'period' => $period,
    'yearLectivo' => $yearLectivo,
    'commentsAll' => $data['commentsAll'] ?? collect(),
    'isPdf' => true
])

    </div>

@endforeach

</body>
</html>