<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ScoresTemplateExport implements FromCollection, WithHeadings
{
    protected $students;

    public function __construct($students)
    {
        $this->students = $students;
    }

    public function collection()
    {
        return $this->students->map(function ($student) {
            return [
                'student_id' => $student->id,
                'estudiante' => $student->full_name,
                'saber' => '',
                'hacer' => '',
                'ser' => ''
            ];
        });
    }

    public function headings(): array
    {
        return [
            'student_id',
            'estudiante',
            'saber',
            'hacer',
            'ser'
        ];
    }
}