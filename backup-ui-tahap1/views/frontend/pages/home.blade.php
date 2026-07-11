<div>
    <section class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-indigo-600 to-violet-700">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute left-20 top-20 h-40 w-40 rounded-full bg-white blur-3xl"></div>
            <div class="absolute bottom-10 right-20 h-56 w-56 rounded-full bg-cyan-300 blur-3xl"></div>
        </div>

        <div class="relative mx-auto grid max-w-7xl grid-cols-1 items-center gap-10 px-5 py-24 lg:grid-cols-2">
            <div>
                <div class="mb-5 inline-flex rounded-full bg-white/15 px-4 py-2 text-sm font-medium text-white">
                    Sistem Informasi Perpustakaan
                </div>

                <h1 class="text-4xl font-extrabold leading-tight text-white md:text-6xl">
                    Sistem Perpustakaan Digital
                </h1>

                <p class="mt-5 max-w-xl text-lg leading-8 text-blue-100">
                    Temukan koleksi buku perpustakaan dengan mudah, cepat, dan tampilan yang modern.
                </p>

                <div class="mt-8 flex gap-4">
                    <a href="{{ route('frontend.buku') }}"
                       class="rounded-2xl bg-white px-6 py-3 font-semibold text-blue-700 shadow-lg hover:bg-blue-50">
                        Lihat Daftar Buku
                    </a>

                    <a href="{{ url('/admin') }}"
                       class="rounded-2xl border border-white/40 px-6 py-3 font-semibold text-white hover:bg-white/10">
                        Login Admin
                    </a>
                </div>
            </div>

            <div class="hidden lg:block">
                <div class="rounded-[2rem] bg-white/15 p-6 shadow-2xl backdrop-blur">
                    <div class="grid grid-cols-2 gap-4">
                        @foreach ($bukus->take(4) as $buku)
                            <div class="rounded-3xl bg-white p-4 shadow">
                                <div class="flex h-44 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-100 to-indigo-100 text-6xl">
                                    📘
                                </div>
                                <p class="mt-3 line-clamp-1 font-bold text-slate-800">
                                    {{ $buku->judul }}
                                </p>
                                <p class="text-sm text-slate-500">
                                    {{ $buku->penulis }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto -mt-10 max-w-7xl px-5">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <div class="rounded-3xl border bg-white p-7 shadow-sm">
                <p class="text-sm text-slate-500">Total Buku</p>
                <h2 class="mt-3 text-4xl font-extrabold">{{ $totalBuku }}</h2>
            </div>

            <div class="rounded-3xl border bg-white p-7 shadow-sm">
                <p class="text-sm text-slate-500">Total Anggota</p>
                <h2 class="mt-3 text-4xl font-extrabold">{{ $totalAnggota }}</h2>
            </div>

            <div class="rounded-3xl border bg-white p-7 shadow-sm">
                <p class="text-sm text-slate-500">Total Peminjaman</p>
                <h2 class="mt-3 text-4xl font-extrabold">{{ $totalPeminjaman }}</h2>
            </div>
        </div>
    </section>

    <section class="mx-auto mt-16 max-w-7xl px-5">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-extrabold">Buku Terbaru</h2>
                <p class="mt-2 text-slate-500">Koleksi buku terbaru yang tersedia di perpustakaan.</p>
            </div>

            <a href="{{ route('frontend.buku') }}" class="font-semibold text-blue-600 hover:text-blue-700">
                Lihat Semua
            </a>
        </div>

        <div class="grid grid-cols-1 gap-7 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($bukus as $buku)
                <x-frontend.book-card :buku="$buku" />
            @empty
                <div class="col-span-full rounded-3xl border bg-white p-10 text-center text-slate-500">
                    Belum ada data buku.
                </div>
            @endforelse
        </div>
    </section>
</div>
