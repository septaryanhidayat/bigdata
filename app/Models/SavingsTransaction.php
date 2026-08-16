<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingsTransaction extends Model
{
    protected $fillable = [
        'student_id',
        'type',
        'transaction_type',
        'amount',
        'balance_after',
        'description',
        'notes',
        'teller_id',
    ];

    protected $casts = [
        'amount' => 'float',
        'balance_after' => 'float',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teller()
    {
        return $this->belongsTo(Employee::class, 'teller_id');
    }

    public function getTransactionTypeAttribute()
    {
        return $this->type;
    }

    public function setTransactionTypeAttribute($value)
    {
        $this->attributes['type'] = $value;
    }

    public function getNotesAttribute()
    {
        return $this->description;
    }

    public function setNotesAttribute($value)
    {
        $this->attributes['description'] = $value;
    }
}
