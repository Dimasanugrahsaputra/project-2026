<?php

namespace App\Providers\Filament;

use App\Filament\Admin\Resources\AnggotaResource;
use App\Filament\Admin\Resources\BukuResource;
use App\Filament\Admin\Resources\DendaResource;
use App\Filament\Admin\Resources\DetailPeminjamanResource;
use App\Filament\Admin\Resources\KategoriBukuResource;
use App\Filament\Admin\Resources\PeminjamanResource;
use App\Filament\Admin\Resources\PengembalianBukuResource;
use App\Filament\Admin\Resources\RakBukuResource;
use App\Filament\Admin\Resources\UserResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()

            ->colors([
                'primary' => Color::Blue,
            ])

            // Dashboard bawaan Filament
            ->pages([
                Pages\Dashboard::class,
            ])

            // Daftarkan resource manual agar pasti muncul di sidebar
            ->resources([
                AnggotaResource::class,
                BukuResource::class,
                DendaResource::class,
                DetailPeminjamanResource::class,
                KategoriBukuResource::class,
                PeminjamanResource::class,
                PengembalianBukuResource::class,
                RakBukuResource::class,
                UserResource::class,
            ])

            // Widget dashboard
            ->discoverWidgets(
                in: app_path('Filament/Admin/Widgets'),
                for: 'App\\Filament\\Admin\\Widgets'
            )

            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])

            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
