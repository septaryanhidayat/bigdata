<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DigitalSignature extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_id',
        'signer_employee_id',
        'certificate_issuer',
        'certificate_serial',
        'signature_hash',
        'verify_token',
        'signed_at',
        'ip_address',
        'passphrase_validated',
        'status',
    ];

    protected $casts = [
        'signed_at' => 'datetime',
        'passphrase_validated' => 'boolean',
    ];

    public function letter(): BelongsTo
    {
        return $this->belongsTo(OfficialLetter::class, 'letter_id');
    }

    public function signer(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'signer_employee_id');
    }
}
