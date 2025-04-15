<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_number',
        'customer_id',
        'itinerary_id',
        'driver_id',
        'user_id',
        'package_status_id',
        'addressee_name',
        'addressee_address',
        'addressee_phone',
        'addressee_email',
        'payment_method',
        'observation'
    ];

    protected static function booted()
    {
        static::creating(function ($shipment) {
            do {
                $code = 'REM' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
            } while (Shipment::where('tracking_number', $code)->exists());

            $shipment->tracking_number = $code;
        });
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(ShipmentStatusLog::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function itinerary(): BelongsTo
    {
        return $this->belongsTo(Itinerary::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(PackageStatus::class, 'package_status_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ShipmentItem::class);
    }

    public function totalCost()
    {
        return $this->items->sum(fn($item) => $item->subtotal());
    }


    public function totalItems()
    {
        return $this->items->sum('quantity');
    }

    public function formattedTotalCost()
    {
        return number_format($this->totalCost(), 0, ',', '.');
    }

    public function formattedTotalItems()
    {
        return number_format($this->totalItems(), 0, ',', '.');
    }
}
