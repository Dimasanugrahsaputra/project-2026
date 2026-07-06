<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\KatalogBukuController;
use Illuminate\Support\Facades\Route;

Route::get('/', [KatalogBukuController::class, 'index'])
    ->name('katalog.index');

Route::get(
    '/buku/{buku}/booking',
    [BookingController::class, 'create']
)->name('booking.create');

Route::post(
    '/buku/{buku}/booking',
    [BookingController::class, 'store']
)
    ->middleware('throttle:10,1')
    ->name('booking.store');

Route::get(
    '/booking/berhasil/{kodeBooking}',
    [BookingController::class, 'success']
)->name('booking.success');

Route::get(
    '/buku/{buku}',
    [KatalogBukuController::class, 'show']
)->name('katalog.show');
