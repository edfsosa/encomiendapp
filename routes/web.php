<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicTrackingController;

Route::get('/tracking', [PublicTrackingController::class, 'index'])->name('tracking.form');
Route::post('/tracking', [PublicTrackingController::class, 'track'])->name('tracking.search');
