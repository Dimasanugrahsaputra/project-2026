<?php

namespace App\Livewire\Frontend;

use App\Models\Buku;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('frontend.layouts.app')]
class BukuPage extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $buku = Buku::query()
            ->when($this->search, function ($query) {
                $query->where('judul', 'like', '%' . $this->search . '%')
                    ->orWhere('kode_buku', 'like', '%' . $this->search . '%')
                    ->orWhere('penulis', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(9);

        return view('frontend.pages.buku', [
            'buku' => $buku,
        ]);
    }
}
