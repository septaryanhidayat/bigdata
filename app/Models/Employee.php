<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'school_id',
        'nip',
        'nik',
        'full_name',
        'title_prefix',
        'title_suffix',
        'gender',
        'phone',
        'email',
        'role_type',
        'employment_status',
        'is_active',
    ];

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
}
