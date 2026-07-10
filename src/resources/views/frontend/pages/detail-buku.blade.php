<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        {{ $buku->judul_buku }} - Detail Buku
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])
</head>

<body class="min-h-screen bg-slate-100 text-slate-900">
    <nav class="bg-slate-900 text-white">
        <div class="mx-auto flex max-w-7xl flex-col gap-4 px-6 py-5 md:flex-row md:items-center md:justify-between">
            <a href="{{ route('katalog.index') }}">
                <h1 class="text-xl font-bold">
                    Perpustakaan Digital
                </h1>

                <p class="text-sm text-slate-300">
                    Sistem Informasi Peminjaman Buku Online
                </p>
            </a>

            <div class="flex flex-wrap items-center gap-3">
                @guest
                    <a
                        href="{{ route('anggota.login.switch') }}"
                        class="rounded-xl bg-emerald-600 px-5 py-2 font-semibold text-white transition hover:bg-emerald-700"
                    >
                        Login Anggota
                    </a>

                    <a
                        href="{{ route('admin.login.switch') }}"
                        class="rounded-xl bg-blue-600 px-5 py-2 font-semibold text-white transition hover:bg-blue-700"
                    >
                        Login Admin
                    </a>
                @else
                    @if (auth()->user()->anggota)
                        <span class="font-semibold text-white">
                            {{ auth()->user()->name }}
                        </span>
                    @else
                        <a
                            href="{{ url('/admin') }}"
                            class="rounded-xl bg-blue-600 px-5 py-2 font-semibold text-white transition hover:bg-blue-700"
                        >
                            Dashboard Admin
                        </a>
                    @endif

                    <form
                        method="POST"
                        action="{{ route('anggota.logout') }}"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="rounded-xl border border-red-400 px-5 py-2 font-semibold text-red-300 transition hover:bg-red-950"
                        >
                            Logout
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-6xl px-6 py-10">
        <a
            href="{{ route('katalog.index') }}"
            class="mb-6 inline-flex rounded-xl bg-slate-800 px-5 py-3 font-semibold text-white transition hover:bg-slate-700"
        >
            ← Kembali ke Katalog
        </a>

        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-100 px-5 py-4 font-medium text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-xl border border-red-200 bg-red-100 px-5 py-4 font-medium text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @php
            $placeholder = 'https://placehold.co/600x800/e2e8f0/334155?text=Cover+Buku';

            if (filled($buku->cover)) {
                $coverUrl = str_starts_with($buku->cover, 'http')
                    ? $buku->cover
                    : asset('storage/' . ltrim($buku->cover, '/'));
            } else {
                $coverUrl = $placeholder;
            }
        @endphp

        <div class="grid overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm lg:grid-cols-2">
            <div class="min-h-[550px] bg-slate-200">
                <img
                    src="{{ $coverUrl }}"
                    alt="Cover {{ $buku->judul_buku }}"
                    class="h-full min-h-[550px] w-full object-cover"
                    onerror="this.onerror=null; this.src='{{ $placeholder }}';"
                >
            </div>

            <div class="p-8">
                <span class="inline-flex rounded-full bg-blue-100 px-4 py-2 text-sm font-semibold text-blue-700">
                    {{ $buku->kode_buku ?? 'Kode belum tersedia' }}
                </span>

                <h1 class="mt-5 text-3xl font-bold text-slate-900">
                    {{ $buku->judul_buku }}
                </h1>

                <div class="mt-4">
                    @if ((int) $buku->stok > 0)
                        <span class="inline-flex rounded-full bg-emerald-100 px-4 py-2 text-sm font-bold text-emerald-700">
                            Tersedia: {{ $buku->stok }}
                        </span>
                    @else
                        <span class="inline-flex rounded-full bg-red-100 px-4 py-2 text-sm font-bold text-red-700">
                            Stok Habis
                        </span>
                    @endif
                </div>

                <div class="mt-6 divide-y divide-slate-200 border-y border-slate-200">
                    <div class="grid grid-cols-2 py-4">
                        <span class="font-semibold text-slate-800">
                            Penulis
                        </span>

                        <span class="text-slate-600">
                            {{ $buku->penulis ?? '-' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 py-4">
                        <span class="font-semibold text-slate-800">
                            Penerbit
                        </span>

                        <span class="text-slate-600">
                            {{ $buku->penerbit ?? '-' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 py-4">
                        <span class="font-semibold text-slate-800">
                            Tahun Terbit
                        </span>

                        <span class="text-slate-600">
                            {{ $buku->tahun_terbit ?? '-' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 py-4">
                        <span class="font-semibold text-slate-800">
                            ISBN
                        </span>

                        <span class="text-slate-600">
                            {{ $buku->isbn ?? '-' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 py-4">
                        <span class="font-semibold text-slate-800">
                            Kategori
                        </span>

                        <span class="text-slate-600">
                            {{ $buku->kategoriBuku?->nama_kategori ?? '-' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 py-4">
                        <span class="font-semibold text-slate-800">
                            Rak Buku
                        </span>

                        <span class="text-slate-600">
                            {{ $buku->rakBuku?->nama_rak ?? '-' }}
                        </span>
                    </div>
                </div>

                <div class="mt-7">
                    <h2 class="text-xl font-bold text-slate-900">
                        Deskripsi Buku
                    </h2>

                    <p class="mt-3 leading-7 text-slate-600">
                        {{ $buku->deskripsi ?: 'Belum ada deskripsi buku.' }}
                    </p>
                </div>

                <div class="mt-7 rounded-2xl border border-blue-200 bg-blue-50 p-5">
                    <h2 class="text-xl font-bold text-blue-900">
                        Meminjam Buku
                    </h2>

                    @if ((int) $buku->stok <= 0)
                        <div class="mt-4 rounded-xl bg-red-100 p-4 text-sm font-medium text-red-700">
                            Stok buku sedang habis.
                        </div>
                    @else
                        @auth
                            @if (auth()->user()->anggota)
                                <p class="mt-2 text-sm leading-6 text-blue-700">
                                    Isi jumlah buku dan tanggal rencana pengambilan.
                                    Permintaan akan diperiksa oleh admin.
                                </p>

                                <form
                                    method="POST"
                                    action="{{ route('meminjam.store', $buku) }}"
                                    class="mt-5 space-y-4"
                                >
                                    @csrf

                                    <div>
                                        <label
                                            for="jumlah"
                                            class="mb-1 block text-sm font-semibold text-slate-700"
                                        >
                                            Jumlah
                                        </label>

                                        <input
                                            id="jumlah"
                                            type="number"
                                            name="jumlah"
                                            value="{{ old('jumlah', 1) }}"
                                            min="1"
                                            max="{{ $buku->stok }}"
                                            required
                                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                        >

                                        @error('jumlah')
                                            <p class="mt-1 text-sm text-red-600">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label
                                            for="tanggal_rencana_pengambilan"
                                            class="mb-1 block text-sm font-semibold text-slate-700"
                                        >
                                            Tanggal Rencana Pengambilan
                                        </label>

                                        <input
                                            id="tanggal_rencana_pengambilan"
                                            type="date"
                                            name="tanggal_rencana_pengambilan"
                                            value="{{ old(
                                                'tanggal_rencana_pengambilan',
                                                now()->addDay()->toDateString()
                                            ) }}"
                                            min="{{ now()->toDateString() }}"
                                            required
                                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                        >

                                        @error('tanggal_rencana_pengambilan')
                                            <p class="mt-1 text-sm text-red-600">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label
                                            for="catatan"
                                            class="mb-1 block text-sm font-semibold text-slate-700"
                                        >
                                            Catatan
                                        </label>

                                        <textarea
                                            id="catatan"
                                            name="catatan"
                                            rows="3"
                                            placeholder="Catatan tambahan, bila ada"
                                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                        >{{ old('catatan') }}</textarea>

                                        @error('catatan')
                                            <p class="mt-1 text-sm text-red-600">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <button
                                        type="submit"
                                        class="w-full rounded-xl bg-blue-600 px-5 py-3 font-semibold text-white transition hover:bg-blue-700"
                                    >
                                        Meminjam
                                    </button>
                                </form>
                            @else
                                <p class="mt-3 text-sm text-blue-700">
                                    Akun yang aktif bukan akun anggota.
                                </p>

                                <a
                                    href="{{ route('anggota.login.switch') }}"
                                    class="mt-4 inline-flex rounded-xl bg-blue-600 px-5 py-3 font-semibold text-white transition hover:bg-blue-700"
                                >
                                    Login Anggota
                                </a>
                            @endif
                        @else
                            <p class="mt-3 text-sm leading-6 text-blue-700">
                                Silakan login atau daftar sebagai anggota terlebih dahulu.
                            </p>

                            <div class="mt-4 flex flex-wrap gap-3">
                                <a
                                    href="{{ route('anggota.login.switch') }}"
                                    class="rounded-xl bg-blue-600 px-5 py-3 font-semibold text-white transition hover:bg-blue-700"
                                >
                                    Login Anggota
                                </a>

                                <a
                                    href="{{ route('anggota.register') }}"
                                    class="rounded-xl border border-blue-300 bg-white px-5 py-3 font-semibold text-blue-700 transition hover:bg-blue-100"
                                >
                                    Daftar Anggota
                                </a>
                            </div>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </main>

    <footer class="mt-10 bg-slate-900 text-white">
        <div class="mx-auto max-w-7xl px-6 py-6 text-center text-sm text-slate-300">
            © {{ date('Y') }} Perpustakaan Digital — Sistem Informasi Peminjaman Buku Online
        </div>
    </footer>
</body>
</html>
