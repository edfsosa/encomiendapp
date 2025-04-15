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
            'status',
            'itinerary.originCity',
            'itinerary.destinationCity',
            'items',
        ]);

        $pdf = Pdf::loadView('shipments.ticket', compact('shipment'))
            ->setPaper([0, 0, 164.41, 99.21]);

        return view('shipments.ticket', compact('shipment'));
    }

    public function download(Shipment $shipment)
    {
        $shipment->load([
            'customer',
            'driver',
            'status',
            'itinerary.originCity',
            'itinerary.destinationCity',
            'items',
        ]);

        $pdf = Pdf::loadView('shipments.ticket', compact('shipment'))
            ->setPaper([0, 0, 164.41, 99.21]);

        return $pdf->download($shipment->tracking_number . '.pdf');
    }
}
