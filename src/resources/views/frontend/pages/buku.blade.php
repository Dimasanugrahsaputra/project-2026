@extends('frontend.layouts.app')

@section('title', 'Katalog Buku - Perpustakaan Digital')

@section('content')
<div class="min-h-screen bg-slate-100">
    <section class="mx-auto max-w-6xl px-6 py-8">
        <div class="mb-6 rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <h1 class="text-3xl font-bold text-slate-900">
                Katalog Buku
            </h1>

            <p class="mt-3 text-sm leading-6 text-slate-600">
                Cari dan lihat koleksi buku yang tersedia di perpustakaan.
                Buku yang tersedia dapat dipesan sementara melalui fitur booking.
            </p>
        </div>

        <form
            action="{{ route('katalog.index') }}"
            method="GET"
            class="mb-7 flex flex-col gap-3 sm:flex-row"
        >
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari judul, kode buku, penulis, penerbit, kategori, rak, atau ISBN..."
                class="w-full rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm text-slate-900 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
            >

            <button
                type="submit"
                class="rounded-xl bg-blue-600 px-7 py-3 text-sm font-bold text-white hover:bg-blue-700"
            >
                Cari
            </button>

            @if (request()->filled('search'))
                <a
                    href="{{ route('katalog.index') }}"
                    class="rounded-xl bg-slate-700 px-7 py-3 text-center text-sm font-bold text-white hover:bg-slate-800"
                >
                    Reset
                </a>
            @endif
        </form>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($bukus as $buku)
                @php
                    $coverUrl = null;

                    if (filled($buku->cover)) {
                        if (
                            str_starts_with($buku->cover, 'http://'\) ||
                            str_starts_with($buku->cover, 'https://'\)
                        ) {
                            $coverUrl = $buku->cover;
                        } elseif (str_starts_with($buku->cover, 'storage/')) {
                            $coverUrl = asset($buku->cover);
                        } else {
                            $coverUrl = asset(
                                'storage/' . ltrim($buku->cover, '/')
                            );
                        }
                    }
                @endphp

                <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                    <div class="relative h-80 overflow-hidden bg-slate-200">
                        @if ($coverUrl)
                            <img
                                src="{{ $coverUrl }}"
                                alt="Cover {{ $buku->judul_buku }}"
                                class="h-full w-full object-cover"
                                onerror="
                                    this.style.display='none';
                                    this.nextElementSibling.style.display='flex';
                                "
                            >

                            <div class="hidden h-full items-center justify-center px-6 text-center">
                                <span class="text-xl font-semibold text-slate-600">
                                    Gambar cover tidak dapat ditampilkan
                                </span>
                            </div>
                        @else
                            <div class="flex h-full items-center justify-center px-6 text-center">
                                <span class="text-xl font-semibold text-slate-600">
                                    Cover belum tersedia
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="p-6">
                        <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                            {{ $buku->kode_buku }}
                        </span>

                        <h2 class="mt-3 text-xl font-bold text-slate-900">
                            {{ $buku->judul_buku }}
                        </h2>

                        <div class="mt-4 space-y-2 text-sm text-slate-600">
                            <p>
                                <span class="font-semibold text-slate-800">
                                    Penulis:
                                </span>
                                {{ $buku->penulis ?: '-' }}
                            </p>

                            <p>
                                <span class="font-semibold text-slate-800">
                                    Penerbit:
                                </span>
                                {{ $buku->penerbit ?: '-' }}
                            </p>

                            <p>
                                <span class="font-semibold text-slate-800">
                                    Tahun:
                                </span>
                                {{ $buku->tahun_terbit ?: '-' }}
                            </p>

                            <p>
                                <span class="font-semibold text-slate-800">
                                    Kategori:
                                </span>
                                {{ $buku->kategoriBuku?->nama_kategori ?: '-' }}
                            </p>

                            <p>
                                <span class="font-semibold text-slate-800">
                                    Rak:
                                </span>
                                {{ $buku->rakBuku?->nama_rak ?: '-' }}
                            </p>
                        </div>

                        <div class="mt-6">
                            <span
                                @class([
                                    'inline-flex rounded-full px-4 py-2 text-sm font-bold',
                                    'bg-emerald-100 text-emerald-700' => (int) $buku->stok > 0,
                                    'bg-red-100 text-red-700' => (int) $buku->stok <= 0,
                                ])
                            >
                                {{ (int) $buku->stok > 0
                                    ? 'Tersedia: ' . $buku->stok
                                    : 'Stok Habis' }}
                            </span>

                            <div class="mt-4 grid grid-cols-2 gap-3">
                                <a
                                    href="{{ route('katalog.show', ['buku' => $buku->id]) }}"
                                    class="rounded-xl bg-slate-900 px-4 py-3 text-center text-sm font-bold text-white hover:bg-slate-700"
                                >
                                    Detail
                                </a>

                                @if ((int) $buku->stok > 0)
                                    <a
                                        href="{{ route('booking.create', ['buku' => $buku->id]) }}"
                                        class="rounded-xl bg-blue-600 px-4 py-3 text-center text-sm font-bold text-white hover:bg-blue-700"
                                    >
                                        Booking Buku
                                    </a>
                                @else
                                    <button
                                        type="button"
                                        disabled
                                        class="cursor-not-allowed rounded-xl bg-slate-300 px-4 py-3 text-sm font-bold text-slate-500"
                                    >
                                        Tidak Tersedia
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-3xl border border-slate-200 bg-white p-12 text-center shadow-sm">
                    <h2 class="text-xl font-bold text-slate-900">
                        Buku tidak ditemukan
                    </h2>

                    <p class="mt-2 text-sm text-slate-600">
                        Data buku belum tersedia atau kata kunci pencarian tidak ditemukan.
                    </p>
                </div>
            @endforelse
        </div>

        @if (
            method_exists($bukus, 'hasPages') &&
            $bukus->hasPages()
        )
            <div class="mt-10">
                {{ $bukus->links() }}
            </div>
        @endif
    </section>
</div>
@endsection
