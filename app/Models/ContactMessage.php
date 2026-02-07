<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    /**
     * Disable updated_at timestamp.
     */
    const UPDATED_AT = null;

    protected $fillable = [
        'name',
        'email',
        'message',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
