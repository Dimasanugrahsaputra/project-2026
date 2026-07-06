@extends('frontend.layouts.app')

@section('title', $buku->judul_buku . ' - Detail Buku')

@section('content')
@php
    $coverUrl = null;

    if (filled($buku->cover)) {
        if (
            str_starts_with($buku->cover, 'http://') ||
            str_starts_with($buku->cover, 'https://')
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

<div class="min-h-screen bg-slate-100">
    <section class="mx-auto max-w-6xl px-6 py-8">
        <a
            href="{{ route('katalog.index') }}"
            class="mb-6 inline-flex rounded-xl bg-slate-900 px-5 py-3 text-sm font-bold text-white transition hover:bg-blue-700"
        >
            ← Kembali ke Katalog
        </a>

        <div class="grid overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm lg:grid-cols-2">
            <div class="min-h-[600px] bg-slate-200">
                @if ($coverUrl)
                    <img
                        src="{{ $coverUrl }}"
                        alt="Cover {{ $buku->judul_buku }}"
                        class="h-full min-h-[600px] w-full object-cover"
                    >
                @else
                    <div class="flex min-h-[600px] items-center justify-center px-8 text-center">
                        <span class="text-3xl font-semibold text-slate-600">
                            Cover belum tersedia
                        </span>
                    </div>
                @endif
            </div>

            <div class="p-8 lg:p-10">
                <span class="inline-flex rounded-full bg-blue-100 px-4 py-2 text-sm font-semibold text-blue-700">
                    {{ $buku->kode_buku }}
                </span>

                <h1 class="mt-4 text-3xl font-bold text-slate-900">
                    {{ $buku->judul_buku }}
                </h1>

                <span
                    @class([
                        'mt-4 inline-flex rounded-full px-4 py-2 text-sm font-bold',
                        'bg-emerald-100 text-emerald-700' => $buku->stok > 0,
                        'bg-red-100 text-red-700' => $buku->stok <= 0,
                    ])
                >
                    {{ $buku->stok > 0
                        ? 'Tersedia: ' . $buku->stok
                        : 'Stok Habis' }}
                </span>

                <div class="mt-8 divide-y divide-slate-200 border-y border-slate-200">
                    <div class="grid grid-cols-2 gap-4 py-4">
                        <span class="font-bold text-slate-900">
                            Penulis
                        </span>

                        <span class="text-slate-600">
                            {{ $buku->penulis ?: '-' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 py-4">
                        <span class="font-bold text-slate-900">
                            Penerbit
                        </span>

                        <span class="text-slate-600">
                            {{ $buku->penerbit ?: '-' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 py-4">
                        <span class="font-bold text-slate-900">
                            Tahun Terbit
                        </span>

                        <span class="text-slate-600">
                            {{ $buku->tahun_terbit ?: '-' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 py-4">
                        <span class="font-bold text-slate-900">
                            ISBN
                        </span>

                        <span class="text-slate-600">
                            {{ $buku->isbn ?: '-' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 py-4">
                        <span class="font-bold text-slate-900">
                            Kategori
                        </span>

                        <span class="text-slate-600">
                            {{ $buku->kategoriBuku?->nama_kategori ?: '-' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 py-4">
                        <span class="font-bold text-slate-900">
                            Rak Buku
                        </span>

                        <span class="text-slate-600">
                            {{ $buku->rakBuku?->nama_rak ?: '-' }}
                        </span>
                    </div>
                </div>

                <div class="mt-8">
                    <h2 class="text-xl font-bold text-slate-900">
                        Deskripsi Buku
                    </h2>

                    <p class="mt-3 whitespace-pre-line leading-7 text-slate-600">
                        {{ $buku->deskripsi ?: 'Belum ada deskripsi buku.' }}
                    </p>
                </div>

                <div class="mt-8 rounded-2xl border border-blue-200 bg-blue-50 p-6">
                    <h2 class="font-bold text-blue-900">
                        Informasi Booking
                    </h2>

                    <p class="mt-2 text-sm leading-6 text-blue-700">
                        Booking merupakan pemesanan sementara.
                        Buku tetap harus diambil langsung di perpustakaan
                        sebelum tanggal booking kedaluwarsa.
                    </p>

                    @if ($buku->stok > 0)
                        <a
                            href="{{ route('booking.create', $buku) }}"
                            class="mt-5 inline-flex w-full justify-center rounded-xl bg-blue-600 px-6 py-3 font-bold text-white transition hover:bg-blue-700"
                        >
                            Booking Buku Ini
                        </a>
                    @else
                        <button
                            type="button"
                            disabled
                            class="mt-5 w-full cursor-not-allowed rounded-xl bg-slate-300 px-6 py-3 font-bold text-slate-500"
                        >
                            Buku Tidak Tersedia
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
