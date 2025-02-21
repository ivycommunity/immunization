<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Caregiver extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */

    protected $fillable = [
        'user_id',
        'phone',
        'relationship',
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

    /**
     * Get the user that owns the Caregiver
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
