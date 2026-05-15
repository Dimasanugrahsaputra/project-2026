<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Users', User::count())
                ->description('Total user sistem')
                ->icon('heroicon-o-users'),

            Stat::make('Anggota', Anggota::count())
                ->description('Total anggota perpustakaan')
                ->icon('heroicon-o-user-group'),

            Stat::make('Buku', Buku::count())
                ->description('Total data buku')
                ->icon('heroicon-o-book-open'),

            Stat::make('Peminjaman', Peminjaman::count())
                ->description('Total transaksi peminjaman')
                ->icon('heroicon-o-arrow-up-tray'),
        ];
    }
}
