@php
    $loginUrl =
        \Illuminate\Support\Facades\Route::has(
            'anggota.login'
        )
            ? route('anggota.login')
            : url('/login-anggota');
@endphp

<footer class="site-footer">
    <div class="container footer-grid">
        <section>
            <h3 class="brand-name">
                Sistem Perpustakaan
            </h3>

            <p>
                Menyediakan akses katalog dan layanan
                peminjaman buku secara mudah, jelas,
                dan terorganisir.
            </p>
        </section>

        <section>
            <h4>Informasi Layanan</h4>

            <ul>
                <li>
                    Senin–Jumat, 08.00–16.00 WIB
                </li>

                <li>
                    library@institusi.ac.id
                </li>

                <li>
                    Jl. Pendidikan No. 45, Jakarta
                </li>
            </ul>
        </section>

        <section>
            <h4>Tautan</h4>

            <ul>
                <li>
                    <a href="{{ route('katalog.index') }}">
                        Katalog Buku
                    </a>
                </li>

                <li>
                    <a href="{{ route('tentang') }}">
                        Tentang Perpustakaan
                    </a>
                </li>

                @guest
                    <li>
                        <a href="{{ $loginUrl }}">
                            Login Anggota
                        </a>
                    </li>
                @endguest
            </ul>
        </section>
    </div>

    <div class="container footer-bottom">
        © {{ now()->year }}
        Sistem Informasi Perpustakaan.
        Seluruh hak cipta dilindungi.
    </div>
</footer>
