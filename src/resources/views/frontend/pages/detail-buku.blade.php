@php
    /*
    |--------------------------------------------------------------------------
    | Sampul Buku
    |--------------------------------------------------------------------------
    */

    $rawCover =
        $buku->cover_url
        ?? $buku->url_gambar
        ?? $buku->gambar_sampul
        ?? $buku->cover
        ?? $buku->gambar
        ?? null;

    $coverUrl = null;

    if (filled($rawCover)) {
        $normalizedCover = ltrim(
            (string) $rawCover,
            '/'
        );

        if (
            \Illuminate\Support\Str::startsWith(
                $normalizedCover,
                [
                    'http://',
                    'https://',
                ]
            )
        ) {
            $coverUrl = $normalizedCover;
        } elseif (
            \Illuminate\Support\Str::startsWith(
                $normalizedCover,
                'storage/'
            )
        ) {
            $coverUrl = asset($normalizedCover);
        } else {
            $coverUrl = asset(
                'storage/' . $normalizedCover
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Ketersediaan Buku
    |--------------------------------------------------------------------------
    */

    $stok = (int) ($buku->stok ?? 0);

    $tersedia = $stok > 0;

    /*
    |--------------------------------------------------------------------------
    | Nilai Awal Form
    |--------------------------------------------------------------------------
    */

    $jumlahAwal = old(
        'jumlah',
        old('jumlah_buku', 1)
    );

    /*
    |--------------------------------------------------------------------------
    | URL Login Anggota
    |--------------------------------------------------------------------------
    */

    $loginUrl =
        \Illuminate\Support\Facades\Route::has(
            'anggota.login'
        )
            ? route(
                'anggota.login',
                [
                    'redirect' => url()->current(),
                ]
            )
            : url(
                '/login-anggota?redirect='
                . urlencode(url()->current())
            );
@endphp

<x-public-layout
    :title="$buku->judul_buku"
    active="katalog"
>
    <main class="page">
        <div class="container">

            {{-- Pesan Berhasil --}}
            @if (session('success'))
                <div
                    style="
                        margin-bottom: 24px;
                        padding: 16px;
                        color: #194f48;
                        background: #d9f2ed;
                        border: 1px solid #9cd1c7;
                        border-radius: 8px;
                    "
                >
                    <strong>
                        Peminjaman berhasil diajukan.
                    </strong>

                    <div style="margin-top: 4px;">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            {{-- Pesan Gagal --}}
            @if (session('error'))
                <div
                    style="
                        margin-bottom: 24px;
                        padding: 16px;
                        color: #93000a;
                        background: #ffdad6;
                        border: 1px solid #ba1a1a;
                        border-radius: 8px;
                    "
                >
                    <strong>
                        Peminjaman gagal.
                    </strong>

                    <div style="margin-top: 4px;">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            {{-- Error Validasi --}}
            @if ($errors->any())
                <div
                    style="
                        margin-bottom: 24px;
                        padding: 16px;
                        color: #93000a;
                        background: #ffdad6;
                        border: 1px solid #ba1a1a;
                        border-radius: 8px;
                    "
                >
                    <strong>
                        Data peminjaman belum benar.
                    </strong>

                    <ul
                        style="
                            margin: 8px 0 0;
                            padding-left: 20px;
                        "
                    >
                        @foreach ($errors->all() as $error)
                            <li>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Breadcrumb --}}
            <nav
                class="breadcrumb"
                aria-label="Breadcrumb"
            >
                <a href="{{ route('home') }}">
                    Beranda
                </a>

                <span
                    class="material-symbols-outlined"
                    style="font-size: 16px"
                >
                    chevron_right
                </span>

                <a href="{{ route('katalog.index') }}">
                    Katalog Buku
                </a>

                <span
                    class="material-symbols-outlined"
                    style="font-size: 16px"
                >
                    chevron_right
                </span>

                <span aria-current="page">
                    {{ $buku->judul_buku }}
                </span>
            </nav>

            <div class="book-detail">

                {{-- Sampul Buku --}}
                <div class="book-detail-cover">
                    @if ($coverUrl)
                        <img
                            src="{{ $coverUrl }}"
                            alt="Sampul {{ $buku->judul_buku }}"
                        >
                    @else
                        <div class="book-cover-placeholder">
                            <span class="material-symbols-outlined">
                                menu_book
                            </span>
                        </div>
                    @endif
                </div>

                {{-- Informasi Buku --}}
                <article>
                    <header class="detail-header">
                        <div class="detail-badges">

                            {{-- Kategori --}}
                            <span class="badge badge-neutral">
                                <span
                                    class="material-symbols-outlined"
                                    style="font-size: 14px"
                                >
                                    category
                                </span>

                                {{
                                    $buku
                                        ->kategoriBuku
                                        ?->nama_kategori
                                    ?? 'Tanpa Kategori'
                                }}
                            </span>

                            {{-- Status Stok --}}
                            <span
                                class="badge {{ $tersedia ? 'badge-success' : 'badge-danger' }}"
                            >
                                <span
                                    class="material-symbols-outlined"
                                    style="font-size: 14px"
                                >
                                    {{
                                        $tersedia
                                            ? 'check_circle'
                                            : 'block'
                                    }}
                                </span>

                                {{
                                    $tersedia
                                        ? 'Tersedia: '
                                            . $stok
                                            . ' buku'
                                        : 'Stok belum tersedia'
                                }}
                            </span>
                        </div>

                        <h1 class="detail-title">
                            {{ $buku->judul_buku }}
                        </h1>

                        <p class="detail-author">
                            oleh

                            <strong>
                                {{
                                    $buku->penulis
                                    ?: 'Penulis belum dicantumkan'
                                }}
                            </strong>
                        </p>
                    </header>

                    {{-- Metadata Buku --}}
                    <div class="detail-meta">
                        <div class="meta-item">
                            <small>
                                Tahun Terbit
                            </small>

                            <strong>
                                {{
                                    $buku->tahun_terbit
                                    ?: '-'
                                }}
                            </strong>
                        </div>

                        <div class="meta-item">
                            <small>
                                Penerbit
                            </small>

                            <strong>
                                {{
                                    $buku->penerbit
                                    ?: '-'
                                }}
                            </strong>
                        </div>

                        <div class="meta-item">
                            <small>
                                ISBN
                            </small>

                            <strong>
                                {{
                                    $buku->isbn
                                    ?: '-'
                                }}
                            </strong>
                        </div>

                        <div class="meta-item">
                            <small>
                                Lokasi Rak
                            </small>

                            <strong>
                                {{
                                    $buku
                                        ->rakBuku
                                        ?->nama_rak
                                    ?? '-'
                                }}
                            </strong>
                        </div>
                    </div>

                    {{-- Deskripsi Buku --}}
                    <section>
                        <h2 class="detail-section-title">
                            Deskripsi Buku
                        </h2>

                        <div class="synopsis">
                            {{
                                $buku->deskripsi
                                ?: 'Deskripsi buku belum tersedia.'
                            }}
                        </div>
                    </section>

                    {{-- Form Peminjaman --}}
                    @auth
                        @if ($tersedia)
                            <section
                                style="
                                    margin-top: 28px;
                                    padding: 20px;
                                    background: #ffffff;
                                    border: 1px solid #d7d9de;
                                    border-radius: 8px;
                                "
                            >
                                <h2
                                    class="detail-section-title"
                                    style="margin-bottom: 16px;"
                                >
                                    Form Pengajuan Peminjaman
                                </h2>

                                <form
                                    id="form-peminjaman"
                                    action="{{ route('meminjam.store', [
                                        'buku' => $buku->getKey(),
                                    ]) }}"
                                    method="POST"
                                >
                                    @csrf

                                    {{-- Jumlah Buku --}}
                                    <div style="margin-bottom: 16px;">
                                        <label
                                            for="jumlah"
                                            style="
                                                display: block;
                                                margin-bottom: 7px;
                                                color: #04162e;
                                                font-size: 14px;
                                                font-weight: 700;
                                            "
                                        >
                                            Jumlah Buku

                                            <span style="color: #ba1a1a;">
                                                *
                                            </span>
                                        </label>

                                        <input
                                            type="number"
                                            id="jumlah"
                                            name="jumlah"
                                            value="{{ $jumlahAwal }}"
                                            min="1"
                                            max="{{ $stok }}"
                                            required
                                            class="input"
                                        >

                                        {{-- Alias untuk controller yang menggunakan jumlah_buku --}}
                                        <input
                                            type="hidden"
                                            id="jumlah_buku"
                                            name="jumlah_buku"
                                            value="{{ $jumlahAwal }}"
                                        >

                                        @error('jumlah')
                                            <small
                                                style="
                                                    display: block;
                                                    margin-top: 6px;
                                                    color: #ba1a1a;
                                                "
                                            >
                                                {{ $message }}
                                            </small>
                                        @enderror

                                        @error('jumlah_buku')
                                            <small
                                                style="
                                                    display: block;
                                                    margin-top: 6px;
                                                    color: #ba1a1a;
                                                "
                                            >
                                                {{ $message }}
                                            </small>
                                        @enderror

                                        <small
                                            style="
                                                display: block;
                                                margin-top: 6px;
                                                color: #5e5f5c;
                                            "
                                        >
                                            Maksimal sesuai stok yang tersedia:
                                            {{ $stok }} buku.
                                        </small>
                                    </div>

                                    {{-- Tanggal Rencana Pengambilan --}}
                                    <div style="margin-bottom: 16px;">
                                        <label
                                            for="tanggal_rencana_pengambilan"
                                            style="
                                                display: block;
                                                margin-bottom: 7px;
                                                color: #04162e;
                                                font-size: 14px;
                                                font-weight: 700;
                                            "
                                        >
                                            Tanggal Rencana Pengambilan

                                            <span style="color: #ba1a1a;">
                                                *
                                            </span>
                                        </label>

                                        <input
                                            type="date"
                                            id="tanggal_rencana_pengambilan"
                                            name="tanggal_rencana_pengambilan"
                                            value="{{ old(
                                                'tanggal_rencana_pengambilan',
                                                now()->addDay()->format('Y-m-d')
                                            ) }}"
                                            min="{{ now()->format('Y-m-d') }}"
                                            required
                                            class="input"
                                        >

                                        @error('tanggal_rencana_pengambilan')
                                            <small
                                                style="
                                                    display: block;
                                                    margin-top: 6px;
                                                    color: #ba1a1a;
                                                "
                                            >
                                                {{ $message }}
                                            </small>
                                        @enderror

                                        <small
                                            style="
                                                display: block;
                                                margin-top: 6px;
                                                color: #5e5f5c;
                                            "
                                        >
                                            Pilih tanggal saat buku akan
                                            diambil di perpustakaan.
                                        </small>
                                    </div>

                                    {{-- Catatan Anggota --}}
                                    <div style="margin-bottom: 20px;">
                                        <label
                                            for="catatan_anggota"
                                            style="
                                                display: block;
                                                margin-bottom: 7px;
                                                color: #04162e;
                                                font-size: 14px;
                                                font-weight: 700;
                                            "
                                        >
                                            Catatan untuk Admin

                                            <span
                                                style="
                                                    color: #5e5f5c;
                                                    font-weight: 400;
                                                "
                                            >
                                                (Opsional)
                                            </span>
                                        </label>

                                        <textarea
                                            id="catatan_anggota"
                                            name="catatan_anggota"
                                            rows="3"
                                            class="textarea"
                                            placeholder="Contoh: Saya akan mengambil buku pada sore hari."
                                        >{{ old('catatan_anggota') }}</textarea>

                                        @error('catatan_anggota')
                                            <small
                                                style="
                                                    display: block;
                                                    margin-top: 6px;
                                                    color: #ba1a1a;
                                                "
                                            >
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>

                                    <div class="detail-actions">
                                        <button
                                            type="submit"
                                            class="button button-primary"
                                        >
                                            <span class="material-symbols-outlined">
                                                bookmark_add
                                            </span>

                                            Ajukan Peminjaman
                                        </button>

                                        <a
                                            href="{{ route('katalog.index') }}"
                                            class="button button-secondary"
                                        >
                                            <span class="material-symbols-outlined">
                                                arrow_back
                                            </span>

                                            Kembali ke Katalog
                                        </a>
                                    </div>
                                </form>
                            </section>
                        @else
                            <div class="detail-actions">
                                <button
                                    type="button"
                                    class="button button-primary"
                                    disabled
                                >
                                    <span class="material-symbols-outlined">
                                        block
                                    </span>

                                    Stok Belum Tersedia
                                </button>

                                <a
                                    href="{{ route('katalog.index') }}"
                                    class="button button-secondary"
                                >
                                    <span class="material-symbols-outlined">
                                        arrow_back
                                    </span>

                                    Kembali ke Katalog
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="detail-actions">
                            <a
                                href="{{ $loginUrl }}"
                                class="button button-primary"
                            >
                                <span class="material-symbols-outlined">
                                    login
                                </span>

                                Login untuk Meminjam
                            </a>

                            <a
                                href="{{ route('katalog.index') }}"
                                class="button button-secondary"
                            >
                                <span class="material-symbols-outlined">
                                    arrow_back
                                </span>

                                Kembali ke Katalog
                            </a>
                        </div>
                    @endauth
                </article>
            </div>

            {{-- Buku Terkait --}}
            @if ($bukuTerkait->isNotEmpty())
                <section class="section related-section">
                    <div class="section-head">
                        <div>
                            <p class="eyebrow">
                                Rekomendasi
                            </p>

                            <h2 class="section-title">
                                Buku Terkait
                            </h2>
                        </div>
                    </div>

                    <div class="book-grid">
                        @foreach ($bukuTerkait as $item)
                            <x-book-card
                                :buku="$item"
                            />
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </main>

    @push('scripts')
        <script>
            document.addEventListener(
                'DOMContentLoaded',
                function () {
                    const jumlahInput =
                        document.getElementById('jumlah');

                    const jumlahBukuInput =
                        document.getElementById('jumlah_buku');

                    const formPeminjaman =
                        document.getElementById('form-peminjaman');

                    function sinkronkanJumlah() {
                        if (
                            jumlahInput
                            && jumlahBukuInput
                        ) {
                            jumlahBukuInput.value =
                                jumlahInput.value;
                        }
                    }

                    jumlahInput?.addEventListener(
                        'input',
                        sinkronkanJumlah
                    );

                    jumlahInput?.addEventListener(
                        'change',
                        sinkronkanJumlah
                    );

                    formPeminjaman?.addEventListener(
                        'submit',
                        sinkronkanJumlah
                    );

                    sinkronkanJumlah();
                }
            );
        </script>
    @endpush
</x-public-layout>
