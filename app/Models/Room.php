<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'code',
        'name',
        'category',
        'capacity',
        'location_building',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
