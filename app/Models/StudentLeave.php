<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentLeave extends Model
{
    protected $fillable = [
        'student_id',
        'guardian_id',
        'start_date',
        'end_date',
        'type',
        'leave_type',
        'reason',
        'attachment_url',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function guardian()
    {
        return $this->belongsTo(Guardian::class);
    }

    public function getLeaveTypeAttribute()
    {
        return $this->type;
    }

    public function setLeaveTypeAttribute($value)
    {
        $this->attributes['type'] = $value;
    }
}
