<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = ['number', 'qr_url', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
