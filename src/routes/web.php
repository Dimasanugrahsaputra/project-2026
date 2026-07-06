<?php

use App\Http\Controllers\KatalogBukuController;
use Illuminate\Support\Facades\Route;

Route::get('/', [KatalogBukuController::class, 'index'])
    ->name('katalog.index');

Route::get('/buku/{buku}', [KatalogBukuController::class, 'show'])
    ->name('katalog.show');
