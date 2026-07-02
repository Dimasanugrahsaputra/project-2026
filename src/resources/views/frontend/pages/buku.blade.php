<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku - Perpustakaan Digital</title>

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

    <main class="max-w-7xl mx-auto px-6 py-10">
        <section class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8 mb-8">
            <h2 class="text-3xl font-bold mb-3">Katalog Buku</h2>
            <p class="text-slate-600 leading-relaxed">
                Cari dan lihat koleksi buku yang tersedia di perpustakaan.
                Pengunjung dapat melihat daftar buku tanpa harus login.
                Proses peminjaman tetap dilakukan secara langsung di perpustakaan.
            </p>
        </section>

        <form action="{{ route('katalog.index') }}" method="GET" class="mb-8">
            <div class="flex flex-col md:flex-row gap-3">
                <input
                    type="text"
                    name="search"
                    value="{{ $search ?? '' }}"
                    placeholder="Cari judul, kode buku, penulis, penerbit, atau ISBN..."
                    class="w-full px-5 py-3 rounded-xl border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                >

                <button
                    type="submit"
                    class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">
                    Cari
                </button>

                @if(!empty($search))
                    <a href="{{ route('katalog.index') }}"
                       class="px-6 py-3 rounded-xl bg-slate-700 hover:bg-slate-800 text-white font-semibold transition text-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        @if($bukus->count())
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($bukus as $buku)
                    <article class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-lg transition">
                        <div class="h-64 bg-slate-200 overflow-hidden">
                            <img
                                src="{{ $buku->cover ?: 'https://placehold.co/600x800/e2e8f0/334155?text=Cover+Buku' }}"
                                alt="{{ $buku->judul_buku }}"
                                class="w-full h-full object-cover"
                                onerror="this.src='https://placehold.co/600x800/e2e8f0/334155?text=Cover+Buku'"
                            >
                        </div>

                        <div class="p-6">
                            <div class="mb-3">
                                <span class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                                    {{ $buku->kode_buku ?? 'Kode belum tersedia' }}
                                </span>
                            </div>

                            <h3 class="text-xl font-bold mb-3">
                                {{ $buku->judul_buku }}
                            </h3>

                            <div class="space-y-1 text-sm text-slate-600 mb-5">
                                <p><span class="font-semibold text-slate-800">Penulis:</span> {{ $buku->penulis ?? '-' }}</p>
                                <p><span class="font-semibold text-slate-800">Penerbit:</span> {{ $buku->penerbit ?? '-' }}</p>
                                <p><span class="font-semibold text-slate-800">Tahun:</span> {{ $buku->tahun_terbit ?? '-' }}</p>
                                <p><span class="font-semibold text-slate-800">Kategori:</span> {{ $buku->kategoriBuku?->nama_kategori ?? '-' }}</p>
                                <p><span class="font-semibold text-slate-800">Rak:</span> {{ $buku->rakBuku?->nama_rak ?? '-' }}</p>
                            </div>

                            <div class="flex items-center justify-between gap-3">
                                @if((int) $buku->stok > 0)
                                    <span class="px-4 py-2 rounded-full bg-emerald-100 text-emerald-700 text-sm font-bold">
                                        Tersedia: {{ $buku->stok }}
                                    </span>
                                @else
                                    <span class="px-4 py-2 rounded-full bg-red-100 text-red-700 text-sm font-bold">
                                        Stok Habis
                                    </span>
                                @endif

                                <a href="{{ route('katalog.show', $buku) }}"
                                   class="px-5 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold transition">
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
            <div class="bg-white rounded-3xl border border-slate-200 p-10 text-center">
                <h3 class="text-xl font-bold mb-2">Buku tidak ditemukan</h3>
                <p class="text-slate-600">
                    Data buku belum tersedia atau kata kunci pencarian tidak ditemukan.
                </p>
            </div>
        @endif
    </main>

    <footer class="mt-10 bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-6 py-6 text-center text-sm text-slate-300">
            © {{ date('Y') }} Perpustakaan Digital - Sistem Informasi Peminjaman Buku Online
        </div>
    </footer>
</body>
</html>
