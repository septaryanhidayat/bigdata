<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacterIndicator extends Model
{
    protected $fillable = [
        'school_id',
        'standard_code',
        'standard_name',
        'indicator_name',
        'order_number',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
