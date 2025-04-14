<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;

class PublicTrackingController extends Controller
{
    public function index()
    {
        return view('tracking.form');
    }

    public function track(Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|string',
        ]);

        $shipment = Shipment::with(['customer', 'driver', 'packageStatus', 'itinerary'])->where('tracking_number', $request->tracking_number)->first();

        if (!$shipment) {
            return back()->with('error', 'No se encontró el envío con ese número de seguimiento.');
        }

        return view('tracking.result', compact('shipment'));
    }
}
