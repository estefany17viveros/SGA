<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'calendar',
        'start_date',
        'end_date',
        'periods',
        'status',
    ];

    /**
     * Boot del modelo: se ejecuta al crear un registro
     */
 protected static function booted()
{
    static::creating(function ($academicYear) {
        self::where('status', 'activo')->update(['status' => 'cerrado']);
        $academicYear->status = 'activo';

        if ($academicYear->calendar === 'A') {
            $academicYear->start_date = Carbon::create($academicYear->year, 1, 1);
            $academicYear->end_date   = Carbon::create($academicYear->year, 12, 31);
        } elseif ($academicYear->calendar === 'B') {
            $academicYear->start_date = Carbon::create($academicYear->year, 7, 1);
            $academicYear->end_date   = Carbon::create($academicYear->year + 1, 6, 30);
        }
    });
}
    /**
     * Relaciones
     */
    

    // Un año académico tiene muchas matrículas
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Scopes opcionales
     */

    // Scope para obtener solo los años activos
    public function scopeActive($query)
    {
        return $query->where('status', 'activo');
    }

    // Scope para obtener solo los años cerrados
    public function scopeClosed($query)
    {
        return $query->where('status', 'cerrado');
    }
}