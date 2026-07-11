<form
    action="{{ route('katalog.index') }}"
    method="GET"
>
    <div class="filter-group">
        <label for="filter-search">
            Pencarian
        </label>

        <input
            id="filter-search"
            type="search"
            name="search"
            value="{{ $search }}"
            class="input"
            placeholder="Judul, penulis, ISBN..."
        >
    </div>

    <div class="filter-group">
        <label for="filter-category">
            Kategori
        </label>

        <select
            id="filter-category"
            name="kategori"
            class="select"
        >
            <option value="">
                Semua kategori
            </option>

            @foreach ($kategoris as $kategori)
                <option
                    value="{{ $kategori->id }}"
                    @selected(
                        (string) $kategoriId
                        ===
                        (string) $kategori->id
                    )
                >
                    {{ $kategori->nama_kategori }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="filter-group">
        <label for="filter-year">
            Tahun Terbit
        </label>

        <select
            id="filter-year"
            name="tahun"
            class="select"
        >
            <option value="">
                Semua tahun
            </option>

            @foreach (
                $tahunTerbit as $itemTahun
            )
                <option
                    value="{{ $itemTahun }}"
                    @selected(
                        (string) $tahun
                        ===
                        (string) $itemTahun
                    )
                >
                    {{ $itemTahun }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="filter-group">
        <label class="checkbox-row">
            <input
                type="checkbox"
                name="tersedia"
                value="1"
                @checked($hanyaTersedia)
            >

            Hanya tampilkan buku tersedia
        </label>
    </div>

    <input
        type="hidden"
        name="urutkan"
        value="{{ $urutkan }}"
    >

    <div class="filter-actions">
        <button
            type="submit"
            class="button button-primary"
        >
            Terapkan Filter
        </button>

        <a
            href="{{ route('katalog.index') }}"
            class="button button-secondary"
        >
            Reset Filter
        </a>
    </div>
</form>
