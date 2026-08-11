<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    protected $fillable = [
        'school_id',
        'coa_id',
        'transaction_date',
        'reference_no',
        'description',
        'debit',
        'credit',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function coa()
    {
        return $this->belongsTo(ChartOfAccount::class, 'coa_id');
    }
}
