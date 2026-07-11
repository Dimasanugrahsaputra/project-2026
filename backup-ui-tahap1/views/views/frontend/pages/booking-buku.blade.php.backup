@extends('frontend.layouts.app')

@section('title', 'Booking Buku - ' . $buku->judul_buku)

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
    <section class="mx-auto max-w-5xl px-6 py-10">
        <a
            href="{{ route('katalog.show', $buku) }}"
            class="mb-6 inline-flex rounded-xl bg-slate-900 px-5 py-3 text-sm font-bold text-white transition hover:bg-slate-700"
        >
            ← Kembali ke Detail Buku
        </a>

        <div class="grid overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm lg:grid-cols-2">
            <div class="bg-slate-200">
                @if ($coverUrl)
                    <img
                        src="{{ $coverUrl }}"
                        alt="Cover {{ $buku->judul_buku }}"
                        class="h-full min-h-[500px] w-full object-cover"
                        onerror="
                            this.style.display='none';
                            this.nextElementSibling.style.display='flex';
                        "
                    >

                    <div class="hidden min-h-[500px] items-center justify-center p-8 text-center">
                        <span class="text-2xl font-bold text-slate-500">
                            Gambar cover tidak dapat ditampilkan
                        </span>
                    </div>
                @else
                    <div class="flex min-h-[500px] items-center justify-center p-8 text-center">
                        <span class="text-2xl font-bold text-slate-500">
                            Cover belum tersedia
                        </span>
                    </div>
                @endif
            </div>

            <div class="p-8">
                <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700">
                    {{ $buku->kode_buku }}
                </span>

                <h1 class="mt-3 text-2xl font-bold text-slate-900">
                    Booking {{ $buku->judul_buku }}
                </h1>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Isi formulir berikut untuk memesan buku sementara.
                    Buku tetap harus diambil langsung di perpustakaan.
                </p>

                <div class="mt-5 rounded-xl bg-emerald-50 p-4 text-sm text-emerald-700">
                    Tersedia untuk booking:
                    <strong>{{ $tersediaBooking }}</strong>
                </div>

                @if ($errors->any())
                    <div class="mt-5 rounded-xl border border-red-200 bg-red-50 p-4">
                        <ul class="space-y-1 text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($tersediaBooking > 0)
                    <form
                        action="{{ route('booking.store', $buku) }}"
                        method="POST"
                        class="mt-6 space-y-5"
                    >
                        @csrf

                        <div>
                            <label
                                for="nama_pemesan"
                                class="mb-2 block text-sm font-bold text-slate-800"
                            >
                                Nama Pemesan
                            </label>

                            <input
                                id="nama_pemesan"
                                name="nama_pemesan"
                                type="text"
                                value="{{ old('nama_pemesan') }}"
                                required
                                maxlength="255"
                                placeholder="Masukkan nama lengkap"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                            >

                            @error('nama_pemesan')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label
                                for="nomor_telepon"
                                class="mb-2 block text-sm font-bold text-slate-800"
                            >
                                Nomor Telepon
                            </label>

                            <input
                                id="nomor_telepon"
                                name="nomor_telepon"
                                type="text"
                                value="{{ old('nomor_telepon') }}"
                                required
                                maxlength="30"
                                placeholder="Contoh: 081234567890"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                            >

                            @error('nomor_telepon')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label
                                for="jumlah"
                                class="mb-2 block text-sm font-bold text-slate-800"
                            >
                                Jumlah Buku
                            </label>

                            <input
                                id="jumlah"
                                name="jumlah"
                                type="number"
                                value="{{ old('jumlah', 1) }}"
                                min="1"
                                max="{{ $tersediaBooking }}"
                                required
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                            >

                            @error('jumlah')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label
                                for="catatan"
                                class="mb-2 block text-sm font-bold text-slate-800"
                            >
                                Catatan
                            </label>

                            <textarea
                                id="catatan"
                                name="catatan"
                                rows="4"
                                maxlength="1000"
                                placeholder="Catatan tambahan, boleh dikosongkan"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                            >{{ old('catatan') }}</textarea>

                            @error('catatan')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            class="w-full rounded-xl bg-blue-600 px-6 py-3 font-bold text-white transition hover:bg-blue-700"
                        >
                            Kirim Booking Buku
                        </button>
                    </form>
                @else
                    <div class="mt-6 rounded-xl border border-red-200 bg-red-50 p-5 text-center text-red-700">
                        Buku tidak tersedia untuk booking saat ini.
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
