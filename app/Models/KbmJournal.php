<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KbmJournal extends Model
{
    protected $fillable = [
        'schedule_id',
        'teacher_id',
        'date',
        'topic',
        'notes',
        'student_present_count',
        'student_absent_count',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Employee::class, 'teacher_id');
    }
}
