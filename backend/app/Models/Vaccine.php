<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    protected $fillable = [
        'vaccine_name',
        'description',
        'disease_prevented',
        'recommended_age',
        'dosage',
        'administration_method',
    ];
    
}
