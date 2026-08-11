<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingsTransaction extends Model
{
    protected $fillable = [
        'student_id',
        'type',
        'amount',
        'balance_after',
        'description',
        'teller_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teller()
    {
        return $this->belongsTo(Employee::class, 'teller_id');
    }
}
