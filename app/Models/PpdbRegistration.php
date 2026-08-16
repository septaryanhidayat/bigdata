<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpdbRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'registration_number',
        'full_name',
        'parent_name',
        'phone_number',
        'target_level',
        'previous_school',
        'status',
        'registration_fee',
        'fee_paid',
        'details_json',
    ];

    protected $casts = [
        'details_json' => 'array',
        'registration_fee' => 'float',
        'fee_paid' => 'boolean',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
