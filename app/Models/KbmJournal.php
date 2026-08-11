<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KbmJournal extends Model
{
    protected $fillable = [
        'school_id',
        'schedule_id',
        'teacher_id',
        'date',
        'topic',
        'notes',
        'student_attendance_summary',
    ];

    protected $casts = [
        'student_attendance_summary' => 'array',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Employee::class, 'teacher_id');
    }
}
