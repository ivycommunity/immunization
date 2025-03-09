<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'baby_id',
        'guardian_id',
        'vaccine_id',
        'doctor_id',
        'appointment_date',
        'status',
        'reminder_sent',
        'notes',
    ];

    
    public function baby()
    {
        return $this->belongsTo(Baby::class);
    }

    
}
