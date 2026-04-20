<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $fillable = [
        'academic_year_id',
        'number',
        'name',
        'start_date',
        'end_date',
        'status',
        'percentage'
    ];
    

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
       public function dimensionComments()
    {
        return $this->hasMany(DimensionComment::class);
    }

}
