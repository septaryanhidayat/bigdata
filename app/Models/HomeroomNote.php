<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeroomNote extends Model
{
    protected $fillable = [
        'student_id',
        'academic_year_id',
        'sick_count',
        'permission_count',
        'absent_count',
        'height_cm',
        'weight_kg',
        'hearing_health',
        'vision_health',
        'dental_health',
        'extracurriculars',
        'notes',
    ];

    protected $casts = [
        'extracurriculars' => 'array',
        'height_cm' => 'float',
        'weight_kg' => 'float',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
