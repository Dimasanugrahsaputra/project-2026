<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatistikPerpustakaan extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Buku', Buku::count())
                ->description('Jumlah semua buku')
                ->icon('heroicon-o-book-open'),

            Stat::make('Total Anggota', Anggota::count())
                ->description('Jumlah anggota terdaftar')
                ->icon('heroicon-o-users'),

            Stat::make('Sedang Dipinjam', Peminjaman::where('status', 'dipinjam')->count())
                ->description('Belum dikembalikan')
                ->icon('heroicon-o-arrow-path-rounded-square'),

            Stat::make('Terlambat', Peminjaman::where('status', 'dipinjam')
                ->whereDate('tanggal_jatuh_tempo', '<', now())
                ->count())
                ->description('Lewat tanggal jatuh tempo')
                ->icon('heroicon-o-exclamation-triangle'),
        ];
    }
}
