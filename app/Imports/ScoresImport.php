<?php

namespace App\Imports;

use App\Models\Score;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ScoresImport implements ToCollection
{
    protected $teacherSubjectId;
    protected $periodId;

    public function __construct($teacherSubjectId, $periodId)
    {
        $this->teacherSubjectId = $teacherSubjectId;
        $this->periodId = $periodId;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows->skip(1) as $row) {

            $student_id = $row[0];
            $saber = floatval($row[2]);
            $hacer = floatval($row[3]);
            $ser   = floatval($row[4]);

            if (!$student_id) continue;

            $total = ($saber + $hacer + $ser) / 3;
            $total = floor($total * 100) / 100;

            Score::updateOrCreate(
                [
                    'student_id' => $student_id,
                    'teacher_subject_id' => $this->teacherSubjectId,
                    'period_id' => $this->periodId
                ],
                [
                    'saber' => $saber,
                    'hacer' => $hacer,
                    'ser'   => $ser,
                    'total' => $total
                ]
            );
        }
    }
}
