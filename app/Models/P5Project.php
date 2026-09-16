<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class P5Project extends Model
{
    use HasFactory;

    protected $table = 'p5_projects';

    protected $fillable = [
        'school_id',
        'classroom_id',
        'academic_year_id',
        'theme',
        'title',
        'description',
        'coordinator_name',
        'target_dimensions',
    ];

    protected $casts = [
        'target_dimensions' => 'array',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
