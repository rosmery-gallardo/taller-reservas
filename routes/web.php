<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\WorkshopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WorkshopController::class, 'index'])->name('workshops.index');
Route::get('/talleres/{workshop}', [WorkshopController::class, 'show'])->name('workshops.show');
Route::post('/talleres/{workshop}/reservas', [BookingController::class, 'store'])->name('bookings.store');
