<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $kategoriPopuler = KategoriBuku::query()
            ->orderBy('nama_kategori')
            ->limit(6)
            ->get();

        $bukuTerbaru = Buku::query()
            ->with([
                'kategoriBuku',
                'rakBuku',
            ])
            ->latest('id')
            ->limit(8)
            ->get();

        return view('frontend.pages.home', [
            'kategoriPopuler' => $kategoriPopuler,
            'bukuTerbaru' => $bukuTerbaru,
        ]);
    }
}
