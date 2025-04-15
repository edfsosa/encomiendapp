<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentStatusLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id',
        'status_id',
        'user_id',
        'changed_at'
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function status()
    {
        return $this->belongsTo(PackageStatus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
