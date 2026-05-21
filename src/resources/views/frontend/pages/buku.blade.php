<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">Daftar Buku</h1>
        <p class="text-slate-500">Cari dan lihat koleksi buku yang tersedia.</p>
    </div>

    <div class="bg-white rounded-xl border shadow-sm p-4 mb-8">
        <input
            type="text"
            wire:model.live.debounce.500ms="search"
            placeholder="Cari judul, kode buku, atau penulis..."
            class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse ($buku as $item)
            <div class="bg-white rounded-xl shadow-sm border p-6 hover:shadow-md transition">
                <div class="h-44 bg-blue-50 rounded-lg flex items-center justify-center mb-4">
                    <span class="text-6xl">📘</span>
                </div>

                <h2 class="font-bold text-lg mb-2">
                    {{ $item->judul }}
                </h2>

                <p class="text-sm text-slate-500 mb-1">
                    Kode: {{ $item->kode_buku }}
                </p>

                <p class="text-sm text-slate-500 mb-1">
                    Penulis: {{ $item->penulis ?? '-' }}
                </p>

                <p class="text-sm text-slate-500 mb-4">
                    Penerbit: {{ $item->penerbit ?? '-' }}
                </p>

                <div class="flex items-center justify-between">
                    <span class="px-3 py-1 rounded-full text-sm {{ $item->stok > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        Stok: {{ $item->stok }}
                    </span>

                    <a href="{{ route('frontend.buku.detail', $item) }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Detail
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white rounded-xl border p-8 text-center text-slate-500">
                Buku tidak ditemukan.
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $buku->links() }}
    </div>
</div>
