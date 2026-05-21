<?php

namespace App\Livewire\Frontend;

use App\Models\Buku;
use Livewire\Component;
use Livewire\WithPagination;

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
        $bukus = Buku::query()
            ->when($this->search, function ($query) {
                $query->where('judul', 'like', '%' . $this->search . '%')
                    ->orWhere('kode_buku', 'like', '%' . $this->search . '%')
                    ->orWhere('penulis', 'like', '%' . $this->search . '%')
                    ->orWhere('penerbit', 'like', '%' . $this->search . '%');
            })
            ->orderByDesc('id')
            ->paginate(6);

        return view('frontend.pages.buku', [
            'bukus' => $bukus,
        ])->layout('frontend.layouts.app');
    }
}
