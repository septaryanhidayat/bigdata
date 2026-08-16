<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'category',
        'format_number_pattern',
        'content_template',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
