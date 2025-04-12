<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',                   // Persona física / jurídica
        'document_type',          // CI / RUC
        'document_number',
        'fantasy_name',
        'phone',
        'phone_alt',
        'email',
        'is_gov_supplier',
        'address',
        'house_number',
        'operation_type',         // B2B / B2C
        'agent_id',
        'group',
        'series',
        'payment_method',
        'payment_days',
        'notes',
    ];

    protected $casts = [
        'is_gov_supplier' => 'boolean',
        'created_at_custom' => 'date',
        'inactive_at' => 'date',
    ];
}
