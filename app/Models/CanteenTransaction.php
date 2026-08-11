<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CanteenTransaction extends Model
{
    protected $fillable = [
        'canteen_outlet_id',
        'student_id',
        'invoice_number',
        'total_amount',
        'rfid_tag_used',
    ];

    public function outlet()
    {
        return $this->belongsTo(CanteenOutlet::class, 'canteen_outlet_id');
    }

    public function canteenOutlet()
    {
        return $this->belongsTo(CanteenOutlet::class, 'canteen_outlet_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
