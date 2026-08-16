<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'school_id',
        'classroom_id',
        'guardian_id',
        'nis',
        'nisn',
        'rfid_tag',
        'full_name',
        'nickname',
        'gender',
        'pob',
        'dob',
        'status',
        'canteen_daily_limit',
        'canteen_balance',
        'savings_balance',
        'birth_place',
        'birth_date',
    ];

    protected $casts = [
        'dob' => 'date',
        'canteen_daily_limit' => 'float',
        'canteen_balance' => 'float',
        'savings_balance' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function guardian(): BelongsTo
    {
        return $this->belongsTo(Guardian::class);
    }

    public function getBirthPlaceAttribute(): ?string
    {
        return $this->pob;
    }

    public function setBirthPlaceAttribute($value)
    {
        $this->attributes['pob'] = $value;
    }

    public function getBirthDateAttribute(): ?string
    {
        return $this->dob?->format('Y-m-d');
    }

    public function setBirthDateAttribute($value)
    {
        $this->attributes['dob'] = $value;
    }
}
