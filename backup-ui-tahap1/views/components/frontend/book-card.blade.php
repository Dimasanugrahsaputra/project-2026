@props([
    'buku'
])

@php
    $coverUrl = $buku->cover ? asset('storage/' . $buku->cover) : null;
@endphp

<article class="group overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">
    <div class="relative bg-gradient-to-br from-blue-100 via-indigo-100 to-violet-100 p-5">
        <div class="absolute left-4 top-4 rounded-full bg-white px-3 py-1 text-xs font-semibold text-blue-600 shadow">
            {{ $buku->kode_buku ?? 'BK' }}
        </div>

        <div class="absolute right-4 top-4 rounded-full px-3 py-1 text-xs font-semibold shadow
            {{ ($buku->stok ?? 0) > 0 ? 'bg-emerald-500 text-white' : 'bg-red-500 text-white' }}">
            {{ ($buku->stok ?? 0) > 0 ? 'Tersedia' : 'Habis' }}
        </div>

        <a href="{{ route('frontend.buku.detail', $buku) }}" class="flex h-72 items-center justify-center pt-8">
            @if ($coverUrl)
                <img src="{{ $coverUrl }}"
                     alt="{{ $buku->judul }}"
                     class="h-full max-h-64 rounded-xl object-cover shadow-2xl transition duration-300 group-hover:scale-105">
            @else
                <div class="flex h-44 w-32 items-center justify-center rounded-2xl bg-blue-600 text-5xl text-white shadow-2xl">
                    📘
                </div>
            @endif
        </a>
    </div>

    <div class="space-y-4 p-6">
        <div>
            <h3 class="line-clamp-2 text-xl font-bold text-slate-950">
                {{ $buku->judul ?? 'Judul Buku' }}
            </h3>

            <div class="mt-3 space-y-1 text-sm text-slate-600">
                <p>Penulis: {{ $buku->penulis ?? '-' }}</p>
                <p>Penerbit: {{ $buku->penerbit ?? '-' }}</p>
                <p>Tahun: {{ $buku->tahun_terbit ?? '-' }}</p>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <span class="rounded-full bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700">
                Stok: {{ $buku->stok ?? 0 }}
            </span>

            <a href="{{ route('frontend.buku.detail', $buku) }}"
               class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700">
                Detail
            </a>
        </div>
    </div>
</article>
