<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuranCriterion extends Model
{
    protected $fillable = [
        'school_id',
        'category',
        'code',
        'name',
        'description',
        'order_number',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
