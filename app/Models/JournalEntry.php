<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    protected $fillable = [
        'school_id',
        'account_id',
        'coa_id',
        'reference_number',
        'reference_no',
        'description',
        'debit',
        'credit',
        'date',
        'transaction_date',
    ];

    protected $casts = [
        'debit' => 'float',
        'credit' => 'float',
        'date' => 'date',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function account()
    {
        return $this->belongsTo(ChartOfAccount::class, 'account_id');
    }

    public function coa()
    {
        return $this->belongsTo(ChartOfAccount::class, 'account_id');
    }

    public function getCoaIdAttribute()
    {
        return $this->account_id;
    }

    public function setCoaIdAttribute($value)
    {
        $this->attributes['account_id'] = $value;
    }

    public function getReferenceNoAttribute()
    {
        return $this->reference_number;
    }

    public function setReferenceNoAttribute($value)
    {
        $this->attributes['reference_number'] = $value;
    }

    public function getTransactionDateAttribute()
    {
        return $this->date;
    }

    public function setTransactionDateAttribute($value)
    {
        $this->attributes['date'] = $value;
    }
}
