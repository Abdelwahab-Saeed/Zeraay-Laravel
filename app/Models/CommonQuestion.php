<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommonQuestion extends Model
{
    protected $fillable = [
        'question',
        'answer',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
