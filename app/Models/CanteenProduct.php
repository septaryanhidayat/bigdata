<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CanteenProduct extends Model
{
    protected $fillable = [
        'canteen_outlet_id',
        'name',
        'category',
        'price',
        'stock',
        'image_url',
        'is_available',
    ];

    public function outlet()
    {
        return $this->belongsTo(CanteenOutlet::class, 'canteen_outlet_id');
    }
}
