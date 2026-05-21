@php
    use Illuminate\Support\Facades\Storage;

    $judul = $buku->judul ?? $buku->judul_buku ?? $buku->nama_buku ?? 'Judul Buku';
    $kode = $buku->kode_buku ?? '-';
    $penulis = $buku->penulis ?? '-';
    $penerbit = $buku->penerbit ?? '-';
    $tahun = $buku->tahun_terbit ?? $buku->tahun ?? '-';
    $isbn = $buku->isbn ?? '-';
    $stok = $buku->stok ?? 0;
    $deskripsi = $buku->deskripsi ?? 'Deskripsi buku belum tersedia.';
@endphp

<div class="min-h-screen bg-slate-50">
    <section class="mx-auto max-w-7xl px-6 py-10">
        <a href="{{ route('frontend.buku') }}" class="mb-6 inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-700">
            ← Kembali ke Daftar Buku
        </a>

        <div class="grid gap-8 lg:grid-cols-[1fr_420px]">
            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div class="grid gap-8 md:grid-cols-[340px_1fr]">
                    <div class="rounded-3xl bg-gradient-to-br from-blue-100 to-indigo-100 p-8">
                        @if (! empty($buku->cover))
                            <img
                                src="{{ Storage::url($buku->cover) }}"
                                alt="{{ $judul }}"
                                class="mx-auto h-[420px] w-full rounded-2xl object-cover shadow-xl"
                            >
                        @else
                            <div class="flex h-[420px] items-center justify-center rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white shadow-xl">
                                <div class="text-center">
                                    <div class="text-7xl">📘</div>
                                    <div class="mt-4 font-bold">Cover Buku</div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div>
                        <span class="inline-flex rounded-full bg-blue-50 px-5 py-2 text-sm font-bold text-blue-600">
                            {{ $kode }}
                        </span>

                        <h1 class="mt-6 text-4xl font-black text-slate-950">
                            {{ $judul }}
                        </h1>

                        <div class="mt-8 space-y-4 text-slate-700">
                            <p><strong class="text-slate-950">Penulis:</strong> {{ $penulis }}</p>
                            <p><strong class="text-slate-950">Penerbit:</strong> {{ $penerbit }}</p>
                            <p><strong class="text-slate-950">Tahun Terbit:</strong> {{ $tahun }}</p>
                            <p><strong class="text-slate-950">ISBN:</strong> {{ $isbn }}</p>
                        </div>

                        <div class="mt-6">
                            <span class="inline-flex rounded-full bg-emerald-100 px-6 py-3 font-black text-emerald-700">
                                Stok: {{ $stok }}
                            </span>
                        </div>

                        <div class="mt-10">
                            <h2 class="text-xl font-black text-slate-950">Deskripsi</h2>
                            <p class="mt-3 leading-7 text-slate-600">
                                {{ $deskripsi }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="h-fit rounded-3xl border border-slate-200 bg-white p-7 shadow-sm">
                <h2 class="text-2xl font-black text-slate-950">Booking Buku</h2>

                <p class="mt-2 text-slate-600">
                    Isi data berikut untuk mengajukan peminjaman buku.
                </p>

                @if ($successMessage)
                    <div class="mt-6 rounded-2xl bg-emerald-100 p-4 font-semibold text-emerald-700">
                        {{ $successMessage }}
                    </div>
                @endif

                @if ($errorMessage)
                    <div class="mt-6 rounded-2xl bg-red-100 p-4 font-semibold text-red-700">
                        {{ $errorMessage }}
                    </div>
                @endif

                @error('booking')
                    <div class="mt-6 rounded-2xl bg-red-100 p-4 font-semibold text-red-700">
                        {{ $message }}
                    </div>
                @enderror

                <form wire:submit.prevent="booking" class="mt-7 space-y-5">
                    <div>
                        <label class="mb-2 block font-bold text-slate-700">Nama Lengkap</label>
                        <input
                            type="text"
                            wire:model="nama_lengkap"
                            class="w-full rounded-2xl border border-slate-300 px-5 py-4 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                            placeholder="Masukkan nama lengkap"
                        >
                        @error('nama_lengkap')
                            <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block font-bold text-slate-700">Email</label>
                        <input
                            type="email"
                            wire:model="email"
                            class="w-full rounded-2xl border border-slate-300 px-5 py-4 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                            placeholder="email@gmail.com"
                        >
                        @error('email')
                            <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block font-bold text-slate-700">No HP</label>
                        <input
                            type="text"
                            wire:model="no_hp"
                            class="w-full rounded-2xl border border-slate-300 px-5 py-4 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                            placeholder="08xxxxxxxxxx"
                        >
                        @error('no_hp')
                            <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block font-bold text-slate-700">Alamat</label>
                        <textarea
                            wire:model="alamat"
                            rows="4"
                            class="w-full rounded-2xl border border-slate-300 px-5 py-4 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                            placeholder="Masukkan alamat"
                        ></textarea>
                        @error('alamat')
                            <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block font-bold text-slate-700">Jumlah</label>
                        <input
                            type="number"
                            min="1"
                            wire:model="jumlah"
                            class="w-full rounded-2xl border border-slate-300 px-5 py-4 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                        >
                        @error('jumlah')
                            <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="mb-2 block font-bold text-slate-700">Tanggal Pinjam</label>
                            <input
                                type="date"
                                wire:model="tanggal_pinjam"
                                class="w-full rounded-2xl border border-slate-300 px-4 py-4 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                            >
                            @error('tanggal_pinjam')
                                <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block font-bold text-slate-700">Jatuh Tempo</label>
                            <input
                                type="date"
                                wire:model="tanggal_jatuh_tempo"
                                class="w-full rounded-2xl border border-slate-300 px-4 py-4 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                            >
                            @error('tanggal_jatuh_tempo')
                                <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        class="w-full rounded-2xl bg-blue-600 px-6 py-4 font-black text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        <span wire:loading.remove>Ajukan Booking</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                </form>
            </div>
        </div>
    </section>
</div>
