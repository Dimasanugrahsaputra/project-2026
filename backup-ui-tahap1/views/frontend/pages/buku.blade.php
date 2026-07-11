<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Katalog Buku - Perpustakaan Digital</title>

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

    <main class="mx-auto max-w-7xl px-6 py-10">
        <section class="mb-8 rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <h2 class="text-3xl font-bold">
                Katalog Buku
            </h2>

            <p class="mt-3 leading-relaxed text-slate-600">
                Cari dan lihat koleksi buku yang tersedia di perpustakaan.
                Pengunjung dapat melihat daftar buku tanpa harus login.
                Anggota dapat login untuk mengajukan peminjaman buku secara online.
            </p>
        </section>

        <form
            action="{{ route('katalog.index') }}"
            method="GET"
            class="mb-8"
        >
            <div class="flex flex-col gap-3 md:flex-row">
                <input
                    type="text"
                    name="search"
                    value="{{ $search ?? '' }}"
                    placeholder="Cari judul, kode buku, penulis, penerbit, atau ISBN..."
                    class="w-full rounded-xl border border-slate-300 bg-white px-5 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                >

                <button
                    type="submit"
                    class="rounded-xl bg-blue-600 px-6 py-3 font-semibold text-white transition hover:bg-blue-700"
                >
                    Cari
                </button>

                @if (! empty($search))
                    <a
                        href="{{ route('katalog.index') }}"
                        class="rounded-xl bg-slate-700 px-6 py-3 text-center font-semibold text-white transition hover:bg-slate-800"
                    >
                        Reset
                    </a>
                @endif
            </div>
        </form>

        @if ($bukus->count())
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($bukus as $buku)
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

                    <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        <div class="h-64 overflow-hidden bg-slate-200">
                            <img
                                src="{{ $coverUrl }}"
                                alt="Cover {{ $buku->judul_buku }}"
                                class="h-full w-full object-cover"
                                onerror="this.onerror=null; this.src='{{ $placeholder }}';"
                            >
                        </div>

                        <div class="p-6">
                            <div class="mb-3">
                                <span class="inline-block rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                    {{ $buku->kode_buku ?? 'Kode belum tersedia' }}
                                </span>
                            </div>

                            <h3 class="mb-3 text-xl font-bold">
                                {{ $buku->judul_buku }}
                            </h3>

                            <div class="mb-5 space-y-2 text-sm text-slate-600">
                                <p>
                                    <span class="font-semibold text-slate-800">
                                        Penulis:
                                    </span>

                                    {{ $buku->penulis ?? '-' }}
                                </p>

                                <p>
                                    <span class="font-semibold text-slate-800">
                                        Penerbit:
                                    </span>

                                    {{ $buku->penerbit ?? '-' }}
                                </p>

                                <p>
                                    <span class="font-semibold text-slate-800">
                                        Tahun:
                                    </span>

                                    {{ $buku->tahun_terbit ?? '-' }}
                                </p>

                                <p>
                                    <span class="font-semibold text-slate-800">
                                        Kategori:
                                    </span>

                                    {{ $buku->kategoriBuku?->nama_kategori ?? '-' }}
                                </p>

                                <p>
                                    <span class="font-semibold text-slate-800">
                                        Rak:
                                    </span>

                                    {{ $buku->rakBuku?->nama_rak ?? '-' }}
                                </p>
                            </div>

                            <div class="flex items-center justify-between gap-3">
                                @if ((int) $buku->stok > 0)
                                    <span class="rounded-full bg-emerald-100 px-4 py-2 text-sm font-bold text-emerald-700">
                                        Tersedia: {{ $buku->stok }}
                                    </span>
                                @else
                                    <span class="rounded-full bg-red-100 px-4 py-2 text-sm font-bold text-red-700">
                                        Stok Habis
                                    </span>
                                @endif

                                <a
                                    href="{{ route('katalog.show', $buku) }}"
                                    class="rounded-xl bg-slate-900 px-5 py-2 font-semibold text-white transition hover:bg-slate-800"
                                >
                                    Detail
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $bukus->links() }}
            </div>
        @else
            <div class="rounded-3xl border border-slate-200 bg-white p-10 text-center">
                <h3 class="text-xl font-bold">
                    Buku tidak ditemukan
                </h3>

                <p class="mt-2 text-slate-600">
                    Data buku belum tersedia atau kata kunci pencarian tidak ditemukan.
                </p>
            </div>
        @endif
    </main>

    <footer class="mt-10 bg-slate-900 text-white">
        <div class="mx-auto max-w-7xl px-6 py-6 text-center text-sm text-slate-300">
            © {{ date('Y') }} Perpustakaan Digital — Sistem Informasi Peminjaman Buku Online
        </div>
    </footer>
</body>
</html>
