<div class="min-h-screen bg-slate-50">
    <section class="mx-auto max-w-3xl px-6 py-16">
        <div class="rounded-3xl border border-slate-200 bg-white p-10 text-center shadow-sm">
            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-emerald-100 text-4xl">
                ✅
            </div>

            <h1 class="mt-6 text-3xl font-black text-slate-950">
                Booking Berhasil
            </h1>

            <p class="mt-3 text-slate-600">
                Pengajuan peminjaman buku berhasil dibuat. Silakan datang ke perpustakaan untuk konfirmasi.
            </p>

            <div class="mt-8 rounded-2xl bg-slate-50 p-6 text-left">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-sm text-slate-500">Kode Peminjaman</p>
                        <p class="font-black text-slate-950">{{ $peminjaman->kode_peminjaman }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Nama Anggota</p>
                        <p class="font-black text-slate-950">{{ $peminjaman->anggota->nama_lengkap ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Tanggal Pinjam</p>
                        <p class="font-black text-slate-950">
                            {{ optional($peminjaman->tanggal_pinjam)->format('d/m/Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Jatuh Tempo</p>
                        <p class="font-black text-slate-950">
                            {{ optional($peminjaman->tanggal_jatuh_tempo)->format('d/m/Y') }}
                        </p>
                    </div>
                </div>

                <div class="mt-6">
                    <p class="text-sm text-slate-500">Buku Dipinjam</p>

                    <div class="mt-3 space-y-3">
                        @foreach ($peminjaman->detailPeminjaman as $detail)
                            <div class="flex items-center justify-between rounded-xl bg-white p-4">
                                <span class="font-bold text-slate-900">
                                    {{ $detail->buku->judul ?? $detail->buku->judul_buku ?? $detail->buku->nama_buku ?? 'Judul Buku' }}
                                </span>

                                <span class="rounded-full bg-blue-100 px-4 py-2 text-sm font-bold text-blue-700">
                                    {{ $detail->jumlah }} buku
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-center gap-3">
                <a
                    href="{{ route('frontend.buku') }}"
                    class="rounded-2xl bg-blue-600 px-6 py-3 font-black text-white shadow-lg shadow-blue-200 hover:bg-blue-700"
                >
                    Kembali ke Daftar Buku
                </a>

                <a
                    href="{{ route('frontend.home') }}"
                    class="rounded-2xl border border-slate-300 px-6 py-3 font-black text-slate-700 hover:bg-slate-50"
                >
                    Beranda
                </a>
            </div>
        </div>
    </section>
</div>
