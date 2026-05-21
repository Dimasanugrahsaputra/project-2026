<?php

namespace App\Livewire\Frontend;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Livewire\Component;

class HomePage extends Component
{
    public function render()
    {
        $bukus = Buku::query()
            ->latest()
            ->limit(6)
            ->get();

        return view('frontend.pages.home', [
            'bukus' => $bukus,
            'totalBuku' => Buku::count(),
            'totalAnggota' => Anggota::count(),
            'totalPeminjaman' => Peminjaman::count(),
        ])->layout('frontend.layouts.app', [
            'title' => 'Perpustakaan Digital',
        ]);
    }
}
