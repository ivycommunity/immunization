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
        'nurse_id',
        'appointment_date',
        'status',
        'reminder_sent',
        'notes',
    ];

    // Relationship with Guardian (User)
    public function guardian()
    {
        return $this->belongsTo(User::class, 'guardian_id');
    }


    public function baby()
    {
        return $this->belongsTo(Baby::class);
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function nurse()
    {
        return $this->belongsTo(User::class, 'nurse_id');
    }

    public function vaccine()
    {
        return $this->belongsTo(Vaccine::class);
    }

}
