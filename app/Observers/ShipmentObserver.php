<?php

namespace App\Observers;

use App\Models\Shipment;
use App\Models\ShipmentStatusLog;

class ShipmentObserver
{
    /**
     * Handle the Shipment "created" event.
     */
    public function created(Shipment $shipment): void
    {
        //
    }

    /**
     * Handle the Shipment "updated" event.
     */
    public function updated(Shipment $shipment): void
    {
        if ($shipment->isDirty('package_status_id')) {
            ShipmentStatusLog::create([
                'shipment_id' => $shipment->id,
                'status_id' => $shipment->package_status_id,
                'user_id' => auth()->id(),
                'changed_at' => now(),
            ]);
        }
    }

    /**
     * Handle the Shipment "deleted" event.
     */
    public function deleted(Shipment $shipment): void
    {
        //
    }

    /**
     * Handle the Shipment "restored" event.
     */
    public function restored(Shipment $shipment): void
    {
        //
    }

    /**
     * Handle the Shipment "force deleted" event.
     */
    public function forceDeleted(Shipment $shipment): void
    {
        //
    }
}
