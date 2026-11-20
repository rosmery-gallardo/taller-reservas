<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\WorkshopController;
use Illuminate\Support\Facades\Route;

Route::get('/workshops', [WorkshopController::class, 'index']);
Route::get('/workshops/{workshop}', [WorkshopController::class, 'show']);
Route::post('/workshops/{workshop}/bookings', [BookingController::class, 'store'])
    ->middleware('throttle:10,1');
