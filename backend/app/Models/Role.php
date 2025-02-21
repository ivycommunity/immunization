<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */

     protected $table = 'roles';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */

     protected $fillable = [
        'roleId',
        'role'
     ];

     /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

     protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

}

