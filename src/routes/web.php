<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KatalogBukuController;
use App\Http\Controllers\MeminjamController;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Utama
|--------------------------------------------------------------------------
|
| Landing page utama Sistem Perpustakaan.
|
*/

Route::get(
    '/',
    [
        HomeController::class,
        'index',
    ]
)->name('home');

/*
|--------------------------------------------------------------------------
| Halaman Tentang
|--------------------------------------------------------------------------
*/

Route::view(
    '/tentang',
    'frontend.pages.tentang'
)->name('tentang');

/*
|--------------------------------------------------------------------------
| Katalog Buku
|--------------------------------------------------------------------------
*/

Route::get(
    '/katalog',
    [
        KatalogBukuController::class,
        'index',
    ]
)->name('katalog.index');

Route::get(
    '/katalog/{buku}',
    [
        KatalogBukuController::class,
        'show',
    ]
)->name('katalog.show');

/*
|--------------------------------------------------------------------------
| Meminjam Buku
|--------------------------------------------------------------------------
|
| Hanya pengguna yang sudah login yang dapat mengajukan peminjaman.
|
*/

Route::post(
    '/katalog/{buku}/meminjam',
    [
        MeminjamController::class,
        'store',
    ]
)
    ->middleware('auth')
    ->name('meminjam.store');

/*
|--------------------------------------------------------------------------
| Login, Register, dan Password Anggota
|--------------------------------------------------------------------------
*/

Route::get(
    '/masuk-anggota',
    function (Request $request) {
        /*
         * Keluar dari akun yang sedang aktif agar pengguna
         * dapat beralih ke halaman login anggota.
         */
        if (Auth::check()) {
            Auth::logout();

            $request
                ->session()
                ->invalidate();

            $request
                ->session()
                ->regenerateToken();
        }

        return redirect()
            ->route('anggota.login');
    }
)->name('anggota.login.switch');

/*
|--------------------------------------------------------------------------
| Halaman Khusus Pengunjung
|--------------------------------------------------------------------------
|
| Halaman berikut hanya dapat dibuka ketika pengguna belum login.
|
*/

Route::middleware('guest')
    ->group(function (): void {
        /*
        |--------------------------------------------------------------------------
        | Login Anggota
        |--------------------------------------------------------------------------
        */

        Route::view(
            '/login-anggota',
            'auth.member-login'
        )->name('anggota.login');

        /*
        |--------------------------------------------------------------------------
        | Register Anggota
        |--------------------------------------------------------------------------
        */

        Route::view(
            '/register-anggota',
            'auth.member-register'
        )->name('anggota.register');

        /*
        |--------------------------------------------------------------------------
        | Lupa Password
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/lupa-password',
            ForgotPassword::class
        )->name('password.request');

        /*
        |--------------------------------------------------------------------------
        | Reset Password
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/reset-password/{token}',
            ResetPassword::class
        )->name('password.reset');
    });

/*
|--------------------------------------------------------------------------
| Login Admin
|--------------------------------------------------------------------------
*/

Route::get(
    '/masuk-admin',
    function (Request $request) {
        /*
         * Keluar dari akun anggota yang sedang aktif sebelum
         * membuka halaman login admin Filament.
         */
        if (Auth::check()) {
            Auth::logout();

            $request
                ->session()
                ->invalidate();

            $request
                ->session()
                ->regenerateToken();
        }

        return redirect()
            ->route(
                'filament.admin.auth.login'
            );
    }
)->name('admin.login.switch');

/*
|--------------------------------------------------------------------------
| Logout Anggota
|--------------------------------------------------------------------------
*/

Route::post(
    '/logout-anggota',
    function (Request $request) {
        Auth::logout();

        $request
            ->session()
            ->invalidate();

        $request
            ->session()
            ->regenerateToken();

        return redirect()
            ->route('katalog.index');
    }
)
    ->middleware('auth')
    ->name('anggota.logout');
