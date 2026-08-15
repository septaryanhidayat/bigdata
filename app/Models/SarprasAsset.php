<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SarprasAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'asset_code',
        'name',
        'category',
        'quantity',
        'location',
        'condition',
        'purchase_cost',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
