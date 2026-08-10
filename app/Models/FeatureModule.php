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
        'sort_order',
    ];

    protected $casts = [
        'highlights' => 'array',
    ];
}
