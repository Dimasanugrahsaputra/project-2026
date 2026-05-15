<?php

namespace App\Providers\Filament;

use App\Filament\Admin\Widgets\LatestAccessLogs;
use App\Filament\Admin\Widgets\StatistikPerpustakaan;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
    ->default()
    ->id('admin')
    ->path('admin')
    ->spa()
    ->login()
    ->passwordReset()
    // ->profile(EditProfilePage::class, isSimple: false)
    ->defaultThemeMode(ThemeMode::Light)
            ->font('Montserrat')
            ->colors([
                'primary' => Color::Blue,
            ])
            ->maxContentWidth(MaxWidth::SevenExtraLarge)

            ->discoverResources(
                in: app_path('Filament/Admin/Resources'),
                for: 'App\\Filament\\Admin\\Resources'
            )

            ->discoverPages(
                in: app_path('Filament/Admin/Pages'),
                for: 'App\\Filament\\Admin\\Pages'
            )

            ->pages([
                Pages\Dashboard::class,
            ])

            ->discoverWidgets(
                in: app_path('Filament/Admin/Widgets'),
                for: 'App\\Filament\\Admin\\Widgets'
            )

            ->widgets([
                StatistikPerpustakaan::class,
                LatestAccessLogs::class,
            ])

            ->plugins([
                FilamentEditProfilePlugin::make(),
            ])

            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Administration')
                    ->collapsed(false),

                NavigationGroup::make()
                    ->label('Master Data')
                    ->collapsed(false),

                NavigationGroup::make()
                    ->label('Transaksi')
                    ->collapsed(false),

                NavigationGroup::make()
                    ->label('Manajemen Pengguna')
                    ->collapsed(false),
            ])

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
