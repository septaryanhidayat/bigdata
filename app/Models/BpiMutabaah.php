<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BpiMutabaah extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'date',
        'sholat_subuh',
        'sholat_zhuhur',
        'sholat_ashar',
        'sholat_maghrib',
        'sholat_isya',
        'dhuha',
        'tahajud',
        'tilawah_juz',
        'hafalan_surah',
        'al_mathurat',
        'infaq_amount',
        'notes',
        'verified_by_parent',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
