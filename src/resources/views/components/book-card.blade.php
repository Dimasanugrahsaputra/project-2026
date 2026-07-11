@props([
    'buku',
])

@php
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

    $tersedia =
        (int) ($buku->stok ?? 0) > 0;

    $kategori =
        $buku->kategoriBuku?->nama_kategori
        ?? 'Tanpa Kategori';
@endphp

<article class="book-card">
    <a
        href="{{ route('katalog.show', $buku) }}"
        class="book-cover-wrap"
        aria-label="Lihat detail {{ $buku->judul_buku }}"
    >
        @if ($coverUrl)
            <img
                src="{{ $coverUrl }}"
                alt="Sampul {{ $buku->judul_buku }}"
                class="book-cover"
                loading="lazy"
            >
        @else
            <div
                class="book-cover-placeholder"
                aria-label="Sampul buku belum tersedia"
            >
                <span class="material-symbols-outlined">
                    menu_book
                </span>
            </div>
        @endif
    </a>

    <div class="book-card-body">
        <div class="book-meta">
            <span class="book-category">
                {{ $kategori }}
            </span>

            <span
                class="badge {{ $tersedia ? 'badge-success' : 'badge-danger' }}"
            >
                <span
                    class="material-symbols-outlined"
                    style="font-size: 14px"
                >
                    {{ $tersedia ? 'check_circle' : 'block' }}
                </span>

                {{ $tersedia ? 'Tersedia' : 'Stok Habis' }}
            </span>
        </div>

        <h3 class="book-title">
            <a href="{{ route('katalog.show', $buku) }}">
                {{ $buku->judul_buku }}
            </a>
        </h3>

        <p class="book-author">
            {{ $buku->penulis ?: 'Penulis belum dicantumkan' }}
        </p>

        <div class="book-card-footer">
            <span>
                {{ $buku->tahun_terbit ?: 'Tahun -' }}
                ·
                Stok {{ (int) ($buku->stok ?? 0) }}
            </span>

            <a
                href="{{ route('katalog.show', $buku) }}"
                class="text-link"
            >
                Detail

                <span
                    class="material-symbols-outlined"
                    style="font-size: 17px"
                >
                    arrow_forward
                </span>
            </a>
        </div>
    </div>
</article>
