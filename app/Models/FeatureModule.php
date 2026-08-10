<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureModule extends Model
{
    protected $fillable = [
        'title',
        'short_title',
        'category',
        'category_name',
        'icon',
        'badge_bg',
        'short_desc',
        'full_desc',
        'highlights',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'highlights' => 'array',
        'is_active' => 'boolean',
    ];
}
