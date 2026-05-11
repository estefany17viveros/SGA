<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ScoresTemplateExport implements
    FromCollection,
    WithHeadings,
    WithStyles,
    ShouldAutoSize
{
    protected $students;

    public function __construct($students)
    {
        $this->students = $students;
    }

    public function headings(): array
    {
        return [
            'ID',
            'NOMBRES',
            'APELLIDOS',
            'SABER',
            'HACER',
            'SER',
            'PROMEDIO',
            'FI',
            'FJ'
        ];
    }

   public function collection()
{
    return collect($this->students)
        ->values()
        ->map(function ($student, $index) {

            $row = $index + 2;

            return [
                'id' => $student->id,

                'nombres' => $student->first_name,

                'apellidos' => $student->last_name,

                'saber' => '',

                'hacer' => '',

                'ser' => '',

                'promedio' => "=TRUNC((D{$row}+E{$row}+F{$row})/3,1)",
                'fj' => '',
                'fi' => '',

                ];
        });
}

    public function styles(Worksheet $sheet)
    {
        // 🔥 ENCABEZADOS
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => [
                    'rgb' => 'FFFFFF'
                ]
            ],

            'fill' => [
                'fillType' => 'solid',
                'startColor' => [
                    'rgb' => '1F4E78'
                ]
            ]
        ]);

        // 🔥 CENTRAR
        $sheet->getStyle('A:I')->getAlignment()->setHorizontal('center');

        // 🔥 BORDES
        $sheet->getStyle('A1:I' . ($this->students->count() + 1))
            ->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ]);

        return [];
    }
}