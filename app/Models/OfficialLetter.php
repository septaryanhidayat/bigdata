<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OfficialLetter extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'type',
        'letter_category',
        'reference_number',
        'agenda_number',
        'title',
        'sender',
        'recipient',
        'letter_date',
        'received_date',
        'content',
        'file_url',
        'security_level',
        'status',
        'created_by',
        'metadata_json',
    ];

    protected $casts = [
        'letter_date' => 'date',
        'received_date' => 'date',
        'metadata_json' => 'array',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function digitalSignature(): HasOne
    {
        return $this->hasOne(DigitalSignature::class, 'letter_id');
    }

    public function dispositions(): HasMany
    {
        return $this->hasMany(LetterDisposition::class, 'letter_id');
    }

    public function auditTrails(): HasMany
    {
        return $this->hasMany(LetterAuditTrail::class, 'letter_id')->latest();
    }

    public function getCategoryLabelAttribute(): string
    {
        $map = [
            'SURAT_EDARAN' => 'Surat Edaran (SE)',
            'SURAT_TUGAS' => 'Surat Tugas (ST)',
            'NOTA_DINAS' => 'Nota Dinas (ND)',
            'SURAT_KETERANGAN' => 'Surat Keterangan (SKet)',
            'UNDANGAN' => 'Surat Undangan',
            'SURAT_KEPUTUSAN' => 'Surat Keputusan (SK)',
            'LAINNYA' => 'Surat Dinas Lainnya',
        ];
        return $map[$this->letter_category] ?? $this->letter_category;
    }

    public function getSecurityBadgeClassAttribute(): string
    {
        return match($this->security_level) {
            'RAHASIA' => 'bg-rose-100 text-rose-800 border-rose-300',
            'KILAT' => 'bg-amber-100 text-amber-800 border-amber-300',
            'SEGERA' => 'bg-blue-100 text-blue-800 border-blue-300',
            default => 'bg-slate-100 text-slate-700 border-slate-300',
        };
    }
}
