<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CbtExam extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'title',
        'subject_name',
        'duration_minutes',
        'total_questions',
        'start_time',
        'end_time',
        'status',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
