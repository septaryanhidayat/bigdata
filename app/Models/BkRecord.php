<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BkRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'type',
        'title',
        'points',
        'description',
        'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
