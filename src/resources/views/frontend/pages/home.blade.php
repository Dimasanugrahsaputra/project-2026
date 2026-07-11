<x-public-layout
    title="Beranda"
    active="beranda"
>
    <main>
        <section class="hero">
            <div class="container hero-inner">
                <p class="eyebrow">
                    Katalog Perpustakaan
                </p>

                <h1 class="display">
                    Temukan buku yang ingin kamu baca.
                </h1>

                <p class="lead">
                    Jelajahi koleksi perpustakaan dan
                    ajukan peminjaman secara online melalui
                    alur yang jelas dan mudah.
                </p>

                <form
                    action="{{ route('katalog.index') }}"
                    method="GET"
                    class="search-panel"
                    role="search"
                >
                    <span class="material-symbols-outlined">
                        search
                    </span>

                    <input
                        type="search"
                        name="search"
                        placeholder="Cari judul, penulis, penerbit, atau ISBN..."
                        aria-label="Cari buku"
                    >

                    <button
                        type="submit"
                        class="button button-primary"
                    >
                        <span class="material-symbols-outlined">
                            search
                        </span>

                        <span>Cari Buku</span>
                    </button>
                </form>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <div class="section-head">
                    <div>
                        <p class="eyebrow">
                            Jelajahi Koleksi
                        </p>

                        <h2 class="section-title">
                            Kategori Populer
                        </h2>
                    </div>

                    <a
                        href="{{ route('katalog.index') }}"
                        class="text-link"
                    >
                        Lihat semua

                        <span class="material-symbols-outlined">
                            arrow_forward
                        </span>
                    </a>
                </div>

                <div class="category-grid">
                    @forelse (
                        $kategoriPopuler as $kategori
                    )
                        <a
                            href="{{ route('katalog.index', [
                                'kategori' => $kategori->id,
                            ]) }}"
                            class="category-card"
                        >
                            <span class="material-symbols-outlined">
                                menu_book
                            </span>

                            <strong>
                                {{ $kategori->nama_kategori }}
                            </strong>
                        </a>
                    @empty
                        @foreach ([
                            'Novel',
                            'Komik',
                            'Majalah',
                            'Pelajaran',
                            'Cerpen',
                            'Sejarah',
                        ] as $kategori)
                            <a
                                href="{{ route('katalog.index', [
                                    'search' => $kategori,
                                ]) }}"
                                class="category-card"
                            >
                                <span class="material-symbols-outlined">
                                    menu_book
                                </span>

                                <strong>
                                    {{ $kategori }}
                                </strong>
                            </a>
                        @endforeach
                    @endforelse
                </div>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <div class="section-head">
                    <div>
                        <p class="eyebrow">
                            Koleksi Terkini
                        </p>

                        <h2 class="section-title">
                            Buku Terbaru
                        </h2>
                    </div>

                    <a
                        href="{{ route('katalog.index') }}"
                        class="text-link"
                    >
                        Lihat katalog

                        <span class="material-symbols-outlined">
                            arrow_forward
                        </span>
                    </a>
                </div>

                @if ($bukuTerbaru->isNotEmpty())
                    <div class="book-grid">
                        @foreach (
                            $bukuTerbaru as $buku
                        )
                            <x-book-card
                                :buku="$buku"
                            />
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <span class="material-symbols-outlined">
                            library_books
                        </span>

                        <h3>Belum ada buku</h3>

                        <p>
                            Koleksi buku terbaru akan muncul
                            setelah admin menambahkan data buku.
                        </p>
                    </div>
                @endif
            </div>
        </section>

        <section class="section">
            <div class="container">
                <div class="section-head">
                    <div>
                        <p class="eyebrow">
                            Alur Layanan
                        </p>

                        <h2 class="section-title">
                            Cara Meminjam Buku
                        </h2>
                    </div>
                </div>

                <div class="process-grid">
                    <article class="process-card">
                        <div class="process-number">
                            1
                        </div>

                        <h3>Pilih Buku</h3>

                        <p>
                            Cari koleksi berdasarkan judul,
                            penulis, kategori, tahun terbit,
                            atau ketersediaan stok.
                        </p>
                    </article>

                    <article class="process-card">
                        <div class="process-number">
                            2
                        </div>

                        <h3>Ajukan Peminjaman</h3>

                        <p>
                            Login sebagai anggota, tentukan
                            tanggal pengambilan, lalu kirim
                            pengajuan peminjaman.
                        </p>
                    </article>

                    <article class="process-card">
                        <div class="process-number">
                            3
                        </div>

                        <h3>Ambil di Perpustakaan</h3>

                        <p>
                            Datang setelah pengajuan disetujui.
                            Bukti peminjaman dikirim setelah
                            buku diserahkan.
                        </p>
                    </article>
                </div>
            </div>
        </section>
    </main>
</x-public-layout>
