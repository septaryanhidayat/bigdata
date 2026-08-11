<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentLeave extends Model
{
    protected $fillable = [
        'school_id',
        'student_id',
        'leave_type',
        'start_date',
        'end_date',
        'reason',
        'attachment_url',
        'status',
        'approved_by',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
