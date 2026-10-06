<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningObjective extends Model
{
    protected $fillable = [
        'school_id',
        'subject_id',
        'academic_year_id',
        'grade_level',
        'code',
        'short_desc',
        'description',
        'semester',
        'order_number',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_number' => 'integer',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
