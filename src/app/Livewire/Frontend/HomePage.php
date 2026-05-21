<?php

namespace App\Livewire\Frontend;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('frontend.layouts.app')]
class HomePage extends Component
{
    public function render()
    {
        return view('frontend.pages.home', [
            'totalBuku' => Buku::count(),
            'totalAnggota' => Anggota::count(),
            'totalPeminjaman' => Peminjaman::count(),
            'bukuTerbaru' => Buku::latest()->take(3)->get(),
        ]);
    }
}
