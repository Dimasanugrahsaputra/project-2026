<div>
    <section class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
        <div class="max-w-7xl mx-auto px-6 py-20">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    Sistem Perpustakaan Digital
                </h1>

                <p class="text-lg text-blue-100 mb-8">
                    Temukan dan lihat koleksi buku perpustakaan dengan mudah.
                </p>

                <a href="{{ route('frontend.buku') }}"
                   class="inline-block bg-white text-blue-700 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50">
                    Lihat Daftar Buku
                </a>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <p class="text-slate-500">Total Buku</p>
                <h2 class="text-4xl font-bold mt-2">{{ $totalBuku }}</h2>
            </div>

            <div class="bg-white rounded-xl shadow-sm border p-6">
                <p class="text-slate-500">Total Anggota</p>
                <h2 class="text-4xl font-bold mt-2">{{ $totalAnggota }}</h2>
            </div>

            <div class="bg-white rounded-xl shadow-sm border p-6">
                <p class="text-slate-500">Total Peminjaman</p>
                <h2 class="text-4xl font-bold mt-2">{{ $totalPeminjaman }}</h2>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold">Buku Terbaru</h2>

            <a href="{{ route('frontend.buku') }}" class="text-blue-600 font-medium hover:underline">
                Lihat Semua
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse ($bukuTerbaru as $item)
                <div class="bg-white rounded-xl shadow-sm border p-6 hover:shadow-md transition">
                    <div class="h-40 bg-blue-50 rounded-lg flex items-center justify-center mb-4">
                        <span class="text-5xl">📘</span>
                    </div>

                    <h3 class="font-bold text-lg mb-2">
                        {{ $item->judul }}
                    </h3>

                    <p class="text-sm text-slate-500 mb-1">
                        Kode: {{ $item->kode_buku }}
                    </p>

                    <p class="text-sm text-slate-500 mb-3">
                        Penulis: {{ $item->penulis ?? '-' }}
                    </p>

                    <div class="flex items-center justify-between">
                        <span class="text-sm {{ $item->stok > 0 ? 'text-green-600' : 'text-red-600' }}">
                            Stok: {{ $item->stok }}
                        </span>

                        <a href="{{ route('frontend.buku.detail', $item) }}"
                           class="text-blue-600 font-medium hover:underline">
                            Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 bg-white rounded-xl border p-8 text-center text-slate-500">
                    Belum ada data buku.
                </div>
            @endforelse
        </div>
    </section>
</div>
