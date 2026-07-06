@extends('frontend.layouts.app')

@section('title', 'Booking Berhasil')

@section('content')
<div class="min-h-screen bg-slate-100 px-6 py-12">
    <div class="mx-auto max-w-2xl rounded-3xl border border-slate-200 bg-white p-8 text-center shadow-sm">
        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-emerald-100 text-4xl font-bold text-emerald-600">
            ✓
        </div>

        <h1 class="mt-6 text-3xl font-bold text-slate-900">
            Booking Berhasil
        </h1>

        <p class="mt-3 leading-7 text-slate-600">
            Booking buku berhasil dikirim. Simpan kode booking berikut
            dan tunjukkan kepada petugas perpustakaan.
        </p>

        <div class="mt-6 rounded-2xl border border-blue-200 bg-blue-50 p-6">
            <p class="text-sm font-semibold text-blue-700">
                Kode Booking
            </p>

            <p class="mt-2 break-all text-2xl font-bold text-blue-900">
                {{ $booking->kode_booking }}
            </p>
        </div>

        <div class="mt-8 overflow-hidden rounded-2xl border border-slate-200 text-left">
            <div class="grid grid-cols-2 gap-4 border-b border-slate-200 px-5 py-4">
                <span class="font-semibold text-slate-800">
                    Judul Buku
                </span>

                <span class="text-right text-slate-600">
                    {{ $booking->buku?->judul_buku ?? '-' }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-4 border-b border-slate-200 px-5 py-4">
                <span class="font-semibold text-slate-800">
                    Nama Pemesan
                </span>

                <span class="text-right text-slate-600">
                    {{ $booking->nama_pemesan }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-4 border-b border-slate-200 px-5 py-4">
                <span class="font-semibold text-slate-800">
                    Nomor Telepon
                </span>

                <span class="text-right text-slate-600">
                    {{ $booking->nomor_telepon }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-4 border-b border-slate-200 px-5 py-4">
                <span class="font-semibold text-slate-800">
                    Jumlah
                </span>

                <span class="text-right text-slate-600">
                    {{ $booking->jumlah }} buku
                </span>
            </div>

            <div class="grid grid-cols-2 gap-4 border-b border-slate-200 px-5 py-4">
                <span class="font-semibold text-slate-800">
                    Tanggal Booking
                </span>

                <span class="text-right text-slate-600">
                    {{ $booking->tanggal_booking?->format('d M Y') ?? '-' }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-4 border-b border-slate-200 px-5 py-4">
                <span class="font-semibold text-slate-800">
                    Berlaku Sampai
                </span>

                <span class="text-right text-slate-600">
                    {{ $booking->tanggal_kedaluwarsa?->format('d M Y') ?? '-' }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-4 px-5 py-4">
                <span class="font-semibold text-slate-800">
                    Status
                </span>

                <span class="text-right">
                    <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-sm font-bold text-amber-700">
                        Menunggu
                    </span>
                </span>
            </div>
        </div>

        <div class="mt-7 rounded-2xl border border-amber-200 bg-amber-50 p-5 text-left">
            <h2 class="font-bold text-amber-900">
                Informasi Penting
            </h2>

            <p class="mt-2 text-sm leading-6 text-amber-700">
                Booking belum menjadi transaksi peminjaman resmi.
                Datanglah ke perpustakaan sebelum tanggal kedaluwarsa.
                Petugas akan memproses peminjaman setelah buku diserahkan.
            </p>
        </div>

        <a
            href="{{ route('katalog.index') }}"
            class="mt-7 inline-flex rounded-xl bg-slate-900 px-6 py-3 font-bold text-white transition hover:bg-blue-700"
        >
            Kembali ke Katalog
        </a>
    </div>
</div>
@endsection
