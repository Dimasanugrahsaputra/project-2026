<div class="max-w-5xl mx-auto px-6 py-12">
    <a href="{{ route('frontend.buku') }}"
       class="inline-block mb-6 text-blue-600 font-medium hover:underline">
        ← Kembali ke Daftar Buku
    </a>

    <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 p-8">
            <div class="h-72 bg-blue-50 rounded-xl flex items-center justify-center">
                <span class="text-8xl">📘</span>
            </div>

            <div class="md:col-span-2">
                <h1 class="text-3xl font-bold mb-4">
                    {{ $buku->judul }}
                </h1>

                <div class="space-y-3 text-slate-700">
                    <p>
                        <span class="font-semibold">Kode Buku:</span>
                        {{ $buku->kode_buku }}
                    </p>

                    <p>
                        <span class="font-semibold">Penulis:</span>
                        {{ $buku->penulis ?? '-' }}
                    </p>

                    <p>
                        <span class="font-semibold">Penerbit:</span>
                        {{ $buku->penerbit ?? '-' }}
                    </p>

                    <p>
                        <span class="font-semibold">Tahun Terbit:</span>
                        {{ $buku->tahun_terbit ?? '-' }}
                    </p>

                    <p>
                        <span class="font-semibold">Stok:</span>
                        <span class="{{ $buku->stok > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $buku->stok }}
                        </span>
                    </p>
                </div>

                <div class="mt-6">
                    @if ($buku->stok > 0)
                        <span class="inline-block bg-green-100 text-green-700 px-4 py-2 rounded-lg font-medium">
                            Buku tersedia
                        </span>
                    @else
                        <span class="inline-block bg-red-100 text-red-700 px-4 py-2 rounded-lg font-medium">
                            Buku sedang tidak tersedia
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="border-t p-8">
            <h2 class="text-xl font-bold mb-3">Deskripsi</h2>

            <p class="text-slate-600 leading-relaxed">
                {{ $buku->deskripsi ?? 'Belum ada deskripsi untuk buku ini.' }}
            </p>
        </div>
    </div>
</div>
