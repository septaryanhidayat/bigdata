<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SppBill extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'student_id',
        'academic_year_id',
        'month_period',
        'amount',
        'discount_amount',
        'paid_amount',
        'status',
        'due_date',
    ];

    protected $casts = [
        'amount' => 'float',
        'discount_amount' => 'float',
        'paid_amount' => 'float',
        'due_date' => 'date',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(SppPayment::class);
    }

    public function getRemainingAmountAttribute(): float
    {
        return max(0, ($this->amount - $this->discount_amount) - $this->paid_amount);
    }
}
