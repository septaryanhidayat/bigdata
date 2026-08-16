<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'student_id',
        'subject_id',
        'academic_year_id',
        'assessment_type',
        'type',
        'competency_code',
        'score',
        'notes',
    ];

    protected $casts = [
        'score' => 'float',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function getTypeAttribute()
    {
        return $this->assessment_type;
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['assessment_type'] = $value;
    }

    public function getPredicateAttribute()
    {
        if ($this->score >= 90) return 'A';
        if ($this->score >= 80) return 'B';
        if ($this->score >= 70) return 'C';
        return 'D';
    }
}
