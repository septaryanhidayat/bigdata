<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CanteenOutlet extends Model
{
    protected $fillable = [
        'school_id',
        'name',
        'owner_name',
        'phone',
        'commission_rate',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function products()
    {
        return $this->hasMany(CanteenProduct::class, 'canteen_outlet_id');
    }
}
