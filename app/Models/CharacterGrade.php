<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacterGrade extends Model
{
    protected $fillable = [
        'student_id',
        'academic_year_id',
        'indicator_scores',
        'mutabaah_sholat_fardhu',
        'mutabaah_sholat_dhuha',
        'mutabaah_tilawah',
        'mutabaah_infaq',
        'bpi_mentor_notes',
    ];

    protected $casts = [
        'indicator_scores' => 'array',
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
