<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SppPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'spp_bill_id',
        'receipt_number',
        'amount_paid',
        'payment_method',
        'cashier_id',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'amount_paid' => 'float',
        'paid_at' => 'datetime',
    ];

    public function sppBill(): BelongsTo
    {
        return $this->belongsTo(SppBill::class);
    }

    public function cashier(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'cashier_id');
    }
}
