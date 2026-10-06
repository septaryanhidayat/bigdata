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
        'father_name',
        'mother_name',
        'father_job',
        'mother_job',
        'guardian_name',
        'guardian_job',
        'guardian_address',
        'previous_school',
        'address',
        'village',
        'district',
        'city',
        'province',
        'bio_data',
    ];

    protected $casts = [
        'dob' => 'date',
        'canteen_daily_limit' => 'float',
        'canteen_balance' => 'float',
        'savings_balance' => 'float',
        'bio_data' => 'array',
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
        return !empty($this->attributes['father_name']) ? $this->attributes['father_name'] : ($this->guardian?->full_name ?? 'M. Rizal Pahlefi');
    }

    public function getMotherNameAttribute(): string
    {
        return !empty($this->attributes['mother_name']) ? $this->attributes['mother_name'] : 'RTS Tiara Hilda Safitri';
    }

    public function getFatherJobAttribute(): string
    {
        return !empty($this->attributes['father_job']) ? $this->attributes['father_job'] : ($this->guardian?->occupation ?? 'Dosen Institut Agama Islam Nusantara');
    }

    public function getMotherJobAttribute(): string
    {
        return !empty($this->attributes['mother_job']) ? $this->attributes['mother_job'] : 'PNS (Perpustakaan Unsri)';
    }

    public function getPreviousSchoolAttribute(): string
    {
        return !empty($this->attributes['previous_school']) ? $this->attributes['previous_school'] : 'TK IT ROBBANI';
    }

    public function getAddressAttribute(): string
    {
        return !empty($this->attributes['address']) ? $this->attributes['address'] : ($this->guardian?->address ?? 'Jl. Sarjana Perumahan Surya Akbar VI Blok A4');
    }

    public function getParentAddressAttribute(): string
    {
        return !empty($this->attributes['address']) ? $this->attributes['address'] : ($this->guardian?->address ?? 'Jl. Sarjana Perumahan Surya Akbar VI Blok A4');
    }

    public function getVillageAttribute(): string
    {
        return !empty($this->attributes['village']) ? $this->attributes['village'] : 'Timbangan';
    }

    public function getDistrictAttribute(): string
    {
        return !empty($this->attributes['district']) ? $this->attributes['district'] : 'Indralaya Utara';
    }

    public function getCityAttribute(): string
    {
        return !empty($this->attributes['city']) ? $this->attributes['city'] : 'Ogan Ilir';
    }

    public function getProvinceAttribute(): string
    {
        return !empty($this->attributes['province']) ? $this->attributes['province'] : 'Sumatera Selatan';
    }

    public function getGuardianNameAttribute(): string
    {
        return !empty($this->attributes['guardian_name']) ? $this->attributes['guardian_name'] : ($this->guardian?->full_name ?? '-');
    }

    public function getGuardianJobAttribute(): string
    {
        return !empty($this->attributes['guardian_job']) ? $this->attributes['guardian_job'] : ($this->guardian?->occupation ?? '-');
    }

    public function getGuardianAddressAttribute(): string
    {
        return !empty($this->attributes['guardian_address']) ? $this->attributes['guardian_address'] : ($this->guardian?->address ?? '-');
    }
}
