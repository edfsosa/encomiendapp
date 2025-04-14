<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicTrackingController;
use App\Http\Controllers\ShipmentTicketController;


Route::get('/tracking', [PublicTrackingController::class, 'index'])->name('tracking.form');
Route::post('/tracking', [PublicTrackingController::class, 'track'])->name('tracking.search');

Route::get('/shipments/{shipment}/ticket', [ShipmentTicketController::class, 'show'])->name('shipments.ticket.view');
Route::get('/shipments/{shipment}/ticket/download', [ShipmentTicketController::class, 'download'])->name('shipments.ticket.download');