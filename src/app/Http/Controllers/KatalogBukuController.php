<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class KatalogBukuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $bukus = Buku::query()
            ->with(['kategoriBuku', 'rakBuku'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('kode_buku', 'like', "%{$search}%")
                        ->orWhere('judul_buku', 'like', "%{$search}%")
                        ->orWhere('penulis', 'like', "%{$search}%")
                        ->orWhere('penerbit', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%")
                        ->orWhereHas('kategoriBuku', function ($query) use ($search) {
                            $query->where('nama_kategori', 'like', "%{$search}%");
                        })
                        ->orWhereHas('rakBuku', function ($query) use ($search) {
                            $query->where('nama_rak', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('frontend.pages.buku', [
            'bukus' => $bukus,
            'search' => $search,
        ]);
    }

    public function show(Buku $buku)
    {
        $buku->load(['kategoriBuku', 'rakBuku']);

        return view('frontend.pages.detail-buku', [
            'buku' => $buku,
        ]);
    }
}
