<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ShipmentTicketController extends Controller
{
    public function show(Shipment $shipment)
    {
        $shipment->load([
            'customer',
            'driver',
            'packageStatus',
            'itinerary.originCity',
            'itinerary.destinationCity',
            'shipmentItems',
        ]);

        return view('shipments.ticket', compact('shipment'));
    }

    public function download(Shipment $shipment)
    {
        $shipment->load([
            'customer',
            'driver',
            'packageStatus',
            'itinerary.originCity',
            'itinerary.destinationCity',
            'shipmentItems',
        ]);

        $pdf = Pdf::loadView('shipments.ticket', compact('shipment'));
        return $pdf->download($shipment->tracking_number . '.pdf');
    }
}
