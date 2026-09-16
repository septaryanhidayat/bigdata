<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Extracurricular extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'name',
        'coach_name',
        'description',
        'is_active',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
