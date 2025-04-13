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
        'origin_city_id',
        'destination_city_id',
        'name',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($itinerary) {
            if ($itinerary->origin_city_id && $itinerary->destination_city_id) {
                $origin = City::find($itinerary->origin_city_id);
                $destination = City::find($itinerary->destination_city_id);

                $itinerary->name = $origin->name . '-' . $destination->name;
            }
        });
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function originCity()
    {
        return $this->belongsTo(City::class, 'origin_city_id');
    }

    public function destinationCity()
    {
        return $this->belongsTo(City::class, 'destination_city_id');
    }
}
