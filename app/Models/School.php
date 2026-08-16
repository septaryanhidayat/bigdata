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
        'address',
        'phone',
        'email',
        'logo_url',
        'kop_image_url',
        'theme_color',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

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
