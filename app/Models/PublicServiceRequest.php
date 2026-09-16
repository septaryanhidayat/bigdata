<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_type',
        'institution_name',
        'applicant_name',
        'email',
        'phone_number',
        'event_date',
        'participants_count',
        'facility_or_type',
        'purpose_description',
        'document_path',
        'status',
        'admin_note',
        'handled_by',
    ];

    protected $casts = [
        'event_date' => 'date',
        'participants_count' => 'integer',
    ];

    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }
}
