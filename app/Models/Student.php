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

    public function grades(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function quranGrade(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(QuranGrade::class);
    }

    public function characterGrade(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(CharacterGrade::class);
    }

    public function homeroomNote(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(HomeroomNote::class);
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

    public function setGenderAttribute($value)
    {
        $val = strtoupper(trim((string)$value));
        $this->attributes['gender'] = (str_starts_with($val, 'P') || $val === 'F') ? 'F' : 'M';
    }

    public function getFatherNameAttribute(): string
    {
        return $this->guardian?->full_name ?? 'M. Rizal Pahlefi';
    }

    public function getMotherNameAttribute(): string
    {
        return 'RTS Tiara Hilda Safitri';
    }

    public function getFatherJobAttribute(): string
    {
        return $this->guardian?->occupation ?? 'Dosen Institut Agama Islam Nusantara';
    }

    public function getMotherJobAttribute(): string
    {
        return 'PNS (Perpustakaan Unsri)';
    }

    public function getPreviousSchoolAttribute(): string
    {
        return 'TK IT ROBBANI';
    }

    public function getAddressAttribute(): string
    {
        return $this->attributes['address'] ?? ($this->guardian?->address ?? 'Jl. Sarjana Perumahan Surya Akbar VI Blok A4');
    }

    public function getParentAddressAttribute(): string
    {
        return $this->guardian?->address ?? 'Jl. Sarjana Perumahan Surya Akbar VI Blok A4';
    }

    public function getVillageAttribute(): string
    {
        return 'Timbangan';
    }

    public function getDistrictAttribute(): string
    {
        return 'Indralaya Utara';
    }

    public function getCityAttribute(): string
    {
        return 'Ogan Ilir';
    }

    public function getProvinceAttribute(): string
    {
        return 'Sumatera Selatan';
    }

    public function getGuardianNameAttribute(): string
    {
        return '-';
    }

    public function getGuardianJobAttribute(): string
    {
        return '-';
    }

    public function getGuardianAddressAttribute(): string
    {
        return '-';
    }
}
