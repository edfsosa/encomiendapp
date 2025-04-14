<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicTrackingController;
use App\Http\Controllers\ShipmentTicketController;
use App\Exports\ShipmentsExport;
use Maatwebsite\Excel\Facades\Excel;


Route::get('/tracking', [PublicTrackingController::class, 'index'])->name('tracking.form');
Route::post('/tracking', [PublicTrackingController::class, 'track'])->name('tracking.search');

Route::get('/shipments/{shipment}/ticket', [ShipmentTicketController::class, 'show'])->name('shipments.ticket.view');
Route::get('/shipments/{shipment}/ticket/download', [ShipmentTicketController::class, 'download'])->name('shipments.ticket.download');

Route::get('/exportar-reporte-envios', function (Request $request) {
    $filters = $request->only(['customer_id', 'from', 'until']);
    $filename = 'reporte-envios-' . now()->format('Ymd-His') . '.xlsx';

    return Excel::download(new ShipmentsExport($filters), $filename);
})->name('export.shipments');
