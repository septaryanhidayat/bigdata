<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LetterAuditTrail extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_id',
        'user_id',
        'action',
        'description',
        'ip_address',
    ];

    public function letter(): BelongsTo
    {
        return $this->belongsTo(OfficialLetter::class, 'letter_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
