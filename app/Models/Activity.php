<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'teacher_id',
        'subject_id',
        'group_id',
        'period_id',
        'type',
        'description',
        'percentage'
    ];

    // 🔗 Relaciones

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function groups()
    {
        return $this->belongsTo(Group::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}
