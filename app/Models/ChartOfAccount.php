<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    protected $fillable = [
        'school_id',
        'code',
        'name',
        'type',
        'current_balance',
        'balance',
    ];

    protected $casts = [
        'current_balance' => 'float',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function getBalanceAttribute()
    {
        return $this->current_balance;
    }

    public function setBalanceAttribute($value)
    {
        $this->attributes['current_balance'] = $value;
    }
}
