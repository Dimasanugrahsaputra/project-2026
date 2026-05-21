<?php

namespace App\Livewire\Frontend;

use App\Models\Peminjaman;
use Livewire\Component;

class BookingSuccessPage extends Component
{
    public Peminjaman $peminjaman;

    public function mount(Peminjaman $peminjaman): void
    {
        $this->peminjaman = $peminjaman->load([
            'anggota',
            'detailPeminjaman.buku',
        ]);
    }

    public function render()
    {
        return view('livewire.frontend.booking-success-page')
            ->layout('frontend.layouts.app');
    }
}
