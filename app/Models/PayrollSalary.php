<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollSalary extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'month_year',
        'basic_salary',
        'position_allowance',
        'transport_allowance',
        'bpjs_deduction',
        'tax_deduction',
        'cash_advance_deduction',
        'net_salary',
        'status',
        'payment_date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
