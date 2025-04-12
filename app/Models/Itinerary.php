<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Itinerary extends Model
{
    use HasFactory;

    protected $fillable = [
        'agency_id',
        'origin',
        'destination',
    ];

    public function agency() : BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

}
