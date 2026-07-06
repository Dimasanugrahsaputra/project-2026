<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $buku->judul_buku }} - Detail Buku</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-900">
    <nav class="bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold">Perpustakaan Digital</h1>
                <p class="text-sm text-slate-300">Sistem Informasi Peminjaman Buku Online</p>
            </div>

            <a href="/admin"
               class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">
                Login Admin
            </a>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-10">
        <a href="{{ route('katalog.index') }}"
           class="inline-block mb-6 px-5 py-3 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-semibold transition">
            ← Kembali ke Katalog
        </a>

        <section class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
                <div class="bg-slate-200 min-h-[500px] flex items-center justify-center">
                    <img
                        src="{{ $buku->cover ?: 'https://placehold.co/700x900/e2e8f0/334155?text=Cover+Buku' }}"
                        alt="{{ $buku->judul_buku }}"
                        class="w-full h-full object-cover"
                        onerror="this.src='https://placehold.co/700x900/e2e8f0/334155?text=Cover+Buku'"
                    >
                </div>

                <div class="p-8">
                    <div class="mb-4">
                        <span class="inline-block px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold">
                            {{ $buku->kode_buku ?? 'Kode belum tersedia' }}
                        </span>
                    </div>

                    <h2 class="text-3xl font-bold mb-4">
                        {{ $buku->judul_buku }}
                    </h2>

                    @if((int) $buku->stok > 0)
                        <span class="inline-block mb-6 px-5 py-2 rounded-full bg-emerald-100 text-emerald-700 font-bold">
                            Tersedia: {{ $buku->stok }}
                        </span>
                    @else
                        <span class="inline-block mb-6 px-5 py-2 rounded-full bg-red-100 text-red-700 font-bold">
                            Stok Habis
                        </span>
                    @endif

                    <div class="space-y-4 text-sm md:text-base">
                        <div class="flex border-b border-slate-200 pb-3">
                            <div class="w-40 font-bold text-slate-800">Penulis</div>
                            <div class="flex-1 text-slate-700">{{ $buku->penulis ?? '-' }}</div>
                        </div>

                        <div class="flex border-b border-slate-200 pb-3">
                            <div class="w-40 font-bold text-slate-800">Penerbit</div>
                            <div class="flex-1 text-slate-700">{{ $buku->penerbit ?? '-' }}</div>
                        </div>

                        <div class="flex border-b border-slate-200 pb-3">
                            <div class="w-40 font-bold text-slate-800">Tahun Terbit</div>
                            <div class="flex-1 text-slate-700">{{ $buku->tahun_terbit ?? '-' }}</div>
                        </div>

                        <div class="flex border-b border-slate-200 pb-3">
                            <div class="w-40 font-bold text-slate-800">ISBN</div>
                            <div class="flex-1 text-slate-700">{{ $buku->isbn ?? '-' }}</div>
                        </div>

                        <div class="flex border-b border-slate-200 pb-3">
                            <div class="w-40 font-bold text-slate-800">Kategori</div>
                            <div class="flex-1 text-slate-700">{{ $buku->kategoriBuku?->nama_kategori ?? '-' }}</div>
                        </div>

                        <div class="flex border-b border-slate-200 pb-3">
                            <div class="w-40 font-bold text-slate-800">Rak Buku</div>
                            <div class="flex-1 text-slate-700">{{ $buku->rakBuku?->nama_rak ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-xl font-bold mb-3">Deskripsi Buku</h3>
                        <p class="text-slate-700 leading-relaxed">
                            {{ $buku->deskripsi ?? 'Belum ada deskripsi buku.' }}
                        </p>
                    </div>

                    <div class="mt-8 p-5 rounded-2xl bg-blue-50 border border-blue-100">
                        <h3 class="font-bold text-blue-800 mb-2">Informasi Peminjaman</h3>
                        <p class="text-blue-700 text-sm leading-relaxed">
                            Peminjaman buku dilakukan secara langsung di perpustakaan.
                            Pengunjung dapat melihat informasi buku melalui website, kemudian datang ke perpustakaan untuk melakukan peminjaman.
                            Transaksi peminjaman akan dicatat oleh admin atau petugas perpustakaan.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="mt-10 bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-6 py-6 text-center text-sm text-slate-300">
            © {{ date('Y') }} Perpustakaan Digital - Sistem Informasi Peminjaman Buku Online
        </div>
    </footer>
</body>
</html>
