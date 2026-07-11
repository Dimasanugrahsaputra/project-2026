<x-public-layout
    title="Katalog Buku"
    active="katalog"
>
    <main class="page">
        <div class="container">
            <header class="catalog-page-header">
                <p class="eyebrow">
                    Koleksi Perpustakaan
                </p>

                <h1 class="page-title">
                    Katalog Buku
                </h1>

                <p class="lead catalog-description">
                    Cari buku berdasarkan judul, penulis,
                    kategori, tahun terbit, dan
                    ketersediaan stok.
                </p>
            </header>

            <div class="catalog-layout">
                <aside
                    class="filter-panel"
                    aria-label="Filter katalog"
                >
                    <h2>Filter</h2>

                    @include(
                        'frontend.pages.partials.catalog-filter'
                    )
                </aside>

                <section>
                    <div class="catalog-toolbar">
                        <div class="muted">
                            Menampilkan
                            {{ $bukus->firstItem() ?? 0 }}
                            –
                            {{ $bukus->lastItem() ?? 0 }}
                            dari
                            {{ $bukus->total() }}
                            buku
                        </div>

                        <div class="catalog-toolbar-right">
                            <button
                                type="button"
                                class="button button-secondary mobile-filter-button"
                                data-open-filter
                            >
                                <span class="material-symbols-outlined">
                                    tune
                                </span>

                                Filter
                            </button>

                            <form
                                action="{{ route('katalog.index') }}"
                                method="GET"
                            >
                                @foreach (
                                    request()->except([
                                        'urutkan',
                                        'page',
                                    ])
                                    as $key => $value
                                )
                                    @if (! is_array($value))
                                        <input
                                            type="hidden"
                                            name="{{ $key }}"
                                            value="{{ $value }}"
                                        >
                                    @endif
                                @endforeach

                                <select
                                    name="urutkan"
                                    class="select"
                                    onchange="this.form.submit()"
                                    aria-label="Urutkan katalog"
                                >
                                    <option
                                        value="terbaru"
                                        @selected(
                                            $urutkan === 'terbaru'
                                        )
                                    >
                                        Terbaru
                                    </option>

                                    <option
                                        value="judul"
                                        @selected(
                                            $urutkan === 'judul'
                                        )
                                    >
                                        Judul A–Z
                                    </option>

                                    <option
                                        value="penulis"
                                        @selected(
                                            $urutkan === 'penulis'
                                        )
                                    >
                                        Penulis A–Z
                                    </option>

                                    <option
                                        value="tersedia"
                                        @selected(
                                            $urutkan === 'tersedia'
                                        )
                                    >
                                        Stok Terbanyak
                                    </option>
                                </select>
                            </form>
                        </div>
                    </div>

                    @if ($bukus->isNotEmpty())
                        <div class="book-grid">
                            @foreach ($bukus as $buku)
                                <x-book-card
                                    :buku="$buku"
                                />
                            @endforeach
                        </div>

                        <div class="pagination-wrap">
                            {{ $bukus->links() }}
                        </div>
                    @else
                        <div class="empty-state">
                            <span class="material-symbols-outlined">
                                search_off
                            </span>

                            <h3>Buku tidak ditemukan</h3>

                            <p>
                                Ubah kata pencarian atau
                                reset filter untuk menampilkan
                                koleksi lain.
                            </p>

                            <a
                                href="{{ route('katalog.index') }}"
                                class="button button-primary"
                            >
                                Reset Pencarian
                            </a>
                        </div>
                    @endif
                </section>
            </div>
        </div>
    </main>

    <div
        class="drawer-backdrop"
        data-filter-backdrop
    ></div>

    <aside
        class="filter-drawer"
        data-filter-drawer
        aria-label="Filter katalog mobile"
    >
        <div class="drawer-head">
            <h2>Filter Katalog</h2>

            <button
                type="button"
                class="icon-button"
                data-close-filter
                aria-label="Tutup filter"
            >
                <span class="material-symbols-outlined">
                    close
                </span>
            </button>
        </div>

        @include(
            'frontend.pages.partials.catalog-filter'
        )
    </aside>
</x-public-layout>
