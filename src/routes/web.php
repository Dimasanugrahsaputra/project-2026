<?php

use App\Livewire\Frontend\BookingSuccessPage;
use App\Livewire\Frontend\BukuPage;
use App\Livewire\Frontend\DetailBukuPage;
use App\Livewire\Frontend\HomePage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('frontend.home');

Route::get('/buku', BukuPage::class)->name('frontend.buku');

Route::get('/buku/{buku}', DetailBukuPage::class)->name('frontend.buku.detail');

Route::get('/booking-success/{peminjaman}', BookingSuccessPage::class)
    ->name('frontend.booking.success');
