<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'ci',
        'name',
        'number_car',
        'license_plate',
        'brand',
        'model',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
