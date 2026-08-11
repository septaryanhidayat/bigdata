<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'code',
        'name',
        'category',
        'passing_grade',
    ];

    protected $casts = [
        'passing_grade' => 'float',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
