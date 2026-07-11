<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class KatalogBukuController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => [
                'nullable',
                'string',
                'max:100',
            ],
            'kategori' => [
                'nullable',
                'integer',
            ],
            'tahun' => [
                'nullable',
                'integer',
                'min:1900',
                'max:' . now()->year,
            ],
            'tersedia' => [
                'nullable',
                'boolean',
            ],
            'urutkan' => [
                'nullable',
                'in:terbaru,judul,penulis,tersedia',
            ],
        ]);

        $search = trim(
            (string) ($validated['search'] ?? '')
        );

        $kategoriId = $validated['kategori'] ?? null;
        $tahun = $validated['tahun'] ?? null;

        $hanyaTersedia = (bool) (
            $validated['tersedia'] ?? false
        );

        $urutkan = $validated['urutkan']
            ?? 'terbaru';

        $query = Buku::query()
            ->with([
                'kategoriBuku',
                'rakBuku',
            ])
            ->when(
                $search !== '',
                function (
                    Builder $query
                ) use ($search): void {
                    $query->where(
                        function (
                            Builder $query
                        ) use ($search): void {
                            $query
                                ->where(
                                    'kode_buku',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'judul_buku',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'penulis',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'penerbit',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'isbn',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhereHas(
                                    'kategoriBuku',
                                    function (
                                        Builder $query
                                    ) use ($search): void {
                                        $query->where(
                                            'nama_kategori',
                                            'like',
                                            "%{$search}%"
                                        );
                                    }
                                )
                                ->orWhereHas(
                                    'rakBuku',
                                    function (
                                        Builder $query
                                    ) use ($search): void {
                                        $query->where(
                                            'nama_rak',
                                            'like',
                                            "%{$search}%"
                                        );
                                    }
                                );
                        }
                    );
                }
            )
            ->when(
                $kategoriId,
                function (
                    Builder $query
                ) use ($kategoriId): void {
                    $query->whereHas(
                        'kategoriBuku',
                        function (
                            Builder $query
                        ) use ($kategoriId): void {
                            $query->whereKey(
                                $kategoriId
                            );
                        }
                    );
                }
            )
            ->when(
                $tahun,
                fn (Builder $query) =>
                    $query->where(
                        'tahun_terbit',
                        $tahun
                    )
            )
            ->when(
                $hanyaTersedia,
                fn (Builder $query) =>
                    $query->where(
                        'stok',
                        '>',
                        0
                    )
            );

        match ($urutkan) {
            'judul' => $query
                ->orderBy('judul_buku'),

            'penulis' => $query
                ->orderBy('penulis'),

            'tersedia' => $query
                ->orderByDesc('stok')
                ->orderBy('judul_buku'),

            default => $query
                ->latest('id'),
        };

        $bukus = $query
            ->paginate(12)
            ->withQueryString();

        $kategoris = KategoriBuku::query()
            ->orderBy('nama_kategori')
            ->get();

        $tahunTerbit = Buku::query()
            ->whereNotNull('tahun_terbit')
            ->distinct()
            ->orderByDesc('tahun_terbit')
            ->pluck('tahun_terbit');

        return view(
            'frontend.pages.buku',
            [
                'bukus' => $bukus,
                'kategoris' => $kategoris,
                'tahunTerbit' => $tahunTerbit,
                'search' => $search,
                'kategoriId' => $kategoriId,
                'tahun' => $tahun,
                'hanyaTersedia' =>
                    $hanyaTersedia,
                'urutkan' => $urutkan,
            ]
        );
    }

    public function show(Buku $buku): View
    {
        $buku->load([
            'kategoriBuku',
            'rakBuku',
        ]);

        $bukuTerkait = Buku::query()
            ->with([
                'kategoriBuku',
                'rakBuku',
            ])
            ->whereKeyNot(
                $buku->getKey()
            )
            ->when(
                $buku->kategoriBuku,
                function (
                    Builder $query
                ) use ($buku): void {
                    $query->whereHas(
                        'kategoriBuku',
                        function (
                            Builder $query
                        ) use ($buku): void {
                            $query->whereKey(
                                $buku
                                    ->kategoriBuku
                                    ->getKey()
                            );
                        }
                    );
                }
            )
            ->latest('id')
            ->limit(4)
            ->get();

        return view(
            'frontend.pages.detail-buku',
            [
                'buku' => $buku,
                'bukuTerkait' =>
                    $bukuTerkait,
            ]
        );
    }
}
