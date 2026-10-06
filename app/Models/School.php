<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'npsn',
        'principal_name',
        'principal_nip',
        'address',
        'village',
        'district',
        'city',
        'province',
        'postal_code',
        'phone',
        'email',
        'website',
        'logo_url',
        'kop_image_url',
        'theme_color',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getPrincipalNipAttribute(): string
    {
        return !empty($this->attributes['principal_nip']) ? $this->attributes['principal_nip'] : '142062021012';
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

    public function getPostalCodeAttribute(): string
    {
        return !empty($this->attributes['postal_code']) ? $this->attributes['postal_code'] : '30662';
    }

    public function getWebsiteAttribute(): string
    {
        return !empty($this->attributes['website']) ? $this->attributes['website'] : 'www.sitrobbani.sch.id';
    }

    public function levels(): HasMany
    {
        return $this->hasMany(Level::class);
    }

    public function classrooms(): HasMany
    {
        return $this->hasMany(Classroom::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
