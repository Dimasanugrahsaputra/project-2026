<?php

use App\Http\Controllers\KatalogBukuController;
use App\Http\Controllers\MeminjamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Utama
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/katalog')
    ->name('home');

/*
|--------------------------------------------------------------------------
| Katalog Buku
|--------------------------------------------------------------------------
*/

Route::get(
    '/katalog',
    [KatalogBukuController::class, 'index']
)->name('katalog.index');

Route::get(
    '/katalog/{buku}',
    [KatalogBukuController::class, 'show']
)->name('katalog.show');

/*
|--------------------------------------------------------------------------
| Meminjam Buku
|--------------------------------------------------------------------------
*/

Route::post(
    '/katalog/{buku}/meminjam',
    [MeminjamController::class, 'store']
)
    ->middleware('auth')
    ->name('meminjam.store');

/*
|--------------------------------------------------------------------------
| Login dan Register Anggota
|--------------------------------------------------------------------------
*/

Route::get('/masuk-anggota', function (Request $request) {
    if (Auth::check()) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    return redirect()->route('anggota.login');
})->name('anggota.login.switch');

Route::middleware('guest')->group(function () {
    Route::view(
        '/login-anggota',
        'auth.member-login'
    )->name('anggota.login');

    Route::view(
        '/register-anggota',
        'auth.member-register'
    )->name('anggota.register');
});

/*
|--------------------------------------------------------------------------
| Login Admin
|--------------------------------------------------------------------------
*/

Route::get('/masuk-admin', function (Request $request) {
    if (Auth::check()) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    return redirect()->route(
        'filament.admin.auth.login'
    );
})->name('admin.login.switch');

/*
|--------------------------------------------------------------------------
| Logout Anggota
|--------------------------------------------------------------------------
*/

Route::post('/logout-anggota', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('katalog.index');
})
    ->middleware('auth')
    ->name('anggota.logout');
