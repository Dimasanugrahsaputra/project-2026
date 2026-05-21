<div class="bg-slate-50 min-h-screen">
    <section class="max-w-7xl mx-auto px-6 py-12">
        <div class="mb-10">
            <h1 class="text-4xl font-black text-slate-900">Daftar Buku</h1>
            <p class="mt-3 text-slate-600">Cari dan lihat koleksi buku yang tersedia di perpustakaan.</p>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-5 mb-10">
            <input
                type="text"
                wire:model.live.debounce.500ms="search"
                placeholder="Cari judul, kode buku, penulis, atau penerbit..."
                class="w-full rounded-2xl border border-slate-300 px-5 py-4 focus:border-blue-500 focus:ring-blue-500"
            >
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            @forelse ($bukus as $buku)
                @php
                    $cover = $buku->cover ? asset('storage/' . $buku->cover) : null;
                @endphp

                <div class="group bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-xl transition duration-300">
                    <div class="relative h-72 bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center">
                        <div class="absolute top-5 left-5">
                            <span class="px-4 py-2 rounded-full bg-white text-blue-600 text-sm font-bold shadow">
                                {{ $buku->kode_buku }}
                            </span>
                        </div>

                        <div class="absolute top-5 right-5">
                            <span class="px-4 py-2 rounded-full {{ $buku->stok > 0 ? 'bg-emerald-500 text-white' : 'bg-red-500 text-white' }} text-sm font-bold shadow">
                                {{ $buku->stok > 0 ? 'Tersedia' : 'Habis' }}
                            </span>
                        </div>

                        @if ($cover)
                            <img
                                src="{{ $cover }}"
                                alt="{{ $buku->judul }}"
                                class="h-56 w-40 object-cover rounded-xl shadow-2xl group-hover:-translate-y-2 transition duration-300"
                            >
                        @else
                            <div class="h-56 w-40 rounded-xl bg-blue-600 shadow-2xl flex items-center justify-center group-hover:-translate-y-2 transition duration-300">
                                <span class="text-6xl">📘</span>
                            </div>
                        @endif
                    </div>

                    <div class="p-7">
                        <h2 class="text-2xl font-black text-slate-900 line-clamp-1">
                            {{ $buku->judul }}
                        </h2>

                        <div class="mt-4 space-y-1 text-slate-600">
                            <p>Penulis: {{ $buku->penulis ?? '-' }}</p>
                            <p>Penerbit: {{ $buku->penerbit ?? '-' }}</p>
                            <p>Tahun: {{ $buku->tahun_terbit ?? '-' }}</p>
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <span class="px-5 py-2 rounded-full bg-emerald-100 text-emerald-700 font-bold">
                                Stok: {{ $buku->stok }}
                            </span>

                            <a
                                href="{{ route('frontend.buku.detail', $buku) }}"
                                class="px-6 py-3 rounded-xl bg-blue-600 text-white font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 transition"
                            >
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl border border-slate-200 p-10 text-center">
                    <p class="text-slate-600">Buku tidak ditemukan.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $bukus->links() }}
        </div>
    </section>
</div>
