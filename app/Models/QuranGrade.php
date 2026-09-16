<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuranGrade extends Model
{
    protected $fillable = [
        'student_id',
        'academic_year_id',
        'tahsin_method',
        'tahsin_level',
        'tahsin_scores',
        'tahsin_final_score',
        'tahsin_predicate',
        'tahsin_notes',
        'tahfidz_target',
        'tahfidz_achievement',
        'tahfidz_score',
        'tahfidz_predicate',
        'tasmi_exam_result',
        'tahfidz_notes',
        'examiner_teacher_id',
    ];

    protected $casts = [
        'tahsin_scores' => 'array',
        'tahsin_final_score' => 'float',
        'tahfidz_score' => 'float',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function examiner()
    {
        return $this->belongsTo(Employee::class, 'examiner_teacher_id');
    }
}
