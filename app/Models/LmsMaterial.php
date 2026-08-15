<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LmsMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'subject_name',
        'title',
        'description',
        'type',
        'file_url',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
