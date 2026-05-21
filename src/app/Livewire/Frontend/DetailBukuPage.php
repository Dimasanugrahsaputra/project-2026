<?php

namespace App\Livewire\Frontend;

use App\Models\Buku;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('frontend.layouts.app')]
class DetailBukuPage extends Component
{
    public Buku $buku;

    public function mount(Buku $buku): void
    {
        $this->buku = $buku;
    }

    public function render()
    {
        return view('frontend.pages.detail-buku', [
            'buku' => $this->buku,
        ]);
    }
}
