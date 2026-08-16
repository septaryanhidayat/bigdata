<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LetterDisposition extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_id',
        'from_employee_id',
        'to_employee_id',
        'instruction',
        'notes',
        'due_date',
        'status',
        'reply_notes',
        'completed_at',
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
    ];

    public function letter(): BelongsTo
    {
        return $this->belongsTo(OfficialLetter::class, 'letter_id');
    }

    public function fromEmployee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'from_employee_id');
    }

    public function toEmployee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'to_employee_id');
    }
}
