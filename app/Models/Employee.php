<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function classrooms(): HasMany
    {
        return $this->hasMany(Classroom::class, 'homeroom_teacher_id');
    }

    public function getFormattedNameAttribute(): string
    {
        $prefix = $this->title_prefix ? $this->title_prefix . ' ' : '';
        $suffix = $this->title_suffix ? ', ' . $this->title_suffix : '';
        return $prefix . $this->full_name . $suffix;
    }

    public function getTitleAttribute(): string
    {
        return $this->title_suffix ?: ($this->title_prefix ?: '');
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title_suffix'] = $value;
    }

    public function getTypeAttribute(): string
    {
        return $this->role_type === 'TEACHER' ? 'GURU' : 'NON_GURU';
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['role_type'] = in_array(strtoupper($value ?? ''), ['GURU', 'TEACHER']) ? 'TEACHER' : 'STAFF';
    }

    public function getPositionAttribute(): ?string
    {
        return $this->employment_status;
    }

    public function setPositionAttribute($value)
    {
        $this->attributes['employment_status'] = $value;
    }
}
