<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportSetting extends Model
{
    protected $fillable = [
        'school_id',
        'kop_header_text',
        'kop_image_url',
        'school_logo_url',
        'jsit_logo_url',
        'foundation_logo_url',
        'stamp_image_url',
        'principal_signature_url',
        'principal_name',
        'principal_nip',
        'report_date',
        'report_city',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
