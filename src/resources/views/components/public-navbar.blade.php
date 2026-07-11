@props([
    'active' => null,
])

@php
    $dashboardUrl =
        \Illuminate\Support\Facades\Route::has(
            'anggota.dashboard'
        )
            ? route('anggota.dashboard')
            : route('katalog.index');

    $loginUrl =
        \Illuminate\Support\Facades\Route::has(
            'anggota.login'
        )
            ? route('anggota.login')
            : url('/login-anggota');

    $registerUrl =
        \Illuminate\Support\Facades\Route::has(
            'anggota.register'
        )
            ? route('anggota.register')
            : url('/register-anggota');

    $logoutUrl =
        \Illuminate\Support\Facades\Route::has(
            'anggota.logout'
        )
            ? route('anggota.logout')
            : url('/logout-anggota');
@endphp

<header class="site-header">
    <div class="container navbar">
        {{-- Brand --}}
        <a
            href="{{ route('home') }}"
            class="brand"
            aria-label="Beranda Sistem Perpustakaan"
        >
            <span
                class="material-symbols-outlined is-filled"
            >
                local_library
            </span>

            <span class="brand-name">
                Sistem Perpustakaan
            </span>
        </a>

        {{-- Navigasi Desktop --}}
        <nav
            class="nav-links"
            aria-label="Navigasi utama"
        >
            <a
                href="{{ route('home') }}"
                class="nav-link {{ $active === 'beranda' ? 'is-active' : '' }}"
            >
                Beranda
            </a>

            <a
                href="{{ route('katalog.index') }}"
                class="nav-link {{ $active === 'katalog' ? 'is-active' : '' }}"
            >
                Katalog Buku
            </a>

            <a
                href="{{ route('tentang') }}"
                class="nav-link {{ $active === 'tentang' ? 'is-active' : '' }}"
            >
                Tentang
            </a>
        </nav>

        {{-- Aksi Navbar --}}
        <div class="nav-actions">
            {{-- Pencarian --}}
            <form
                action="{{ route('katalog.index') }}"
                method="GET"
                class="nav-search"
                role="search"
            >
                <span class="material-symbols-outlined">
                    search
                </span>

                <input
                    type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari buku..."
                    aria-label="Cari buku"
                >
            </form>

            {{-- Tombol Akun --}}
            @auth
                <a
                    href="{{ $dashboardUrl }}"
                    class="button button-primary"
                >
                    <span class="material-symbols-outlined">
                        dashboard
                    </span>

                    Dashboard
                </a>

                <form
                    action="{{ $logoutUrl }}"
                    method="POST"
                >
                    @csrf

                    <button
                        type="submit"
                        class="button button-secondary"
                    >
                        <span class="material-symbols-outlined">
                            logout
                        </span>

                        Keluar
                    </button>
                </form>
            @else
                <a
                    href="{{ $registerUrl }}"
                    class="button button-secondary"
                >
                    <span class="material-symbols-outlined">
                        person_add
                    </span>

                    Daftar Anggota
                </a>

                <a
                    href="{{ $loginUrl }}"
                    class="button button-primary"
                >
                    <span class="material-symbols-outlined">
                        login
                    </span>

                    Login Anggota
                </a>
            @endauth

            {{-- Tombol Menu Mobile --}}
            <button
                type="button"
                class="mobile-menu-button"
                aria-label="Buka menu"
                aria-expanded="false"
                data-open-mobile-menu
            >
                <span class="material-symbols-outlined">
                    menu
                </span>
            </button>
        </div>
    </div>
</header>

{{-- Backdrop Menu Mobile --}}
<div
    class="drawer-backdrop"
    data-menu-backdrop
></div>

{{-- Menu Mobile --}}
<aside
    class="mobile-drawer"
    data-mobile-menu
    aria-label="Menu mobile"
>
    <div class="mobile-drawer-head">
        <a
            href="{{ route('home') }}"
            class="brand"
        >
            <span
                class="material-symbols-outlined is-filled"
            >
                local_library
            </span>

            <span class="brand-name">
                Perpustakaan
            </span>
        </a>

        <button
            type="button"
            class="icon-button"
            aria-label="Tutup menu"
            data-close-mobile-menu
        >
            <span class="material-symbols-outlined">
                close
            </span>
        </button>
    </div>

    <nav class="mobile-drawer-nav">
        <a
            href="{{ route('home') }}"
            class="{{ $active === 'beranda' ? 'is-active' : '' }}"
        >
            <span class="material-symbols-outlined">
                home
            </span>

            Beranda
        </a>

        <a
            href="{{ route('katalog.index') }}"
            class="{{ $active === 'katalog' ? 'is-active' : '' }}"
        >
            <span class="material-symbols-outlined">
                menu_book
            </span>

            Katalog Buku
        </a>

        <a
            href="{{ route('tentang') }}"
            class="{{ $active === 'tentang' ? 'is-active' : '' }}"
        >
            <span class="material-symbols-outlined">
                info
            </span>

            Tentang
        </a>

        @auth
            <a href="{{ $dashboardUrl }}">
                <span class="material-symbols-outlined">
                    dashboard
                </span>

                Dashboard
            </a>

            <form
                action="{{ $logoutUrl }}"
                method="POST"
            >
                @csrf

                <button type="submit">
                    <span class="material-symbols-outlined">
                        logout
                    </span>

                    Keluar
                </button>
            </form>
        @else
            <a href="{{ $loginUrl }}">
                <span class="material-symbols-outlined">
                    login
                </span>

                Login Anggota
            </a>

            <a href="{{ $registerUrl }}">
                <span class="material-symbols-outlined">
                    person_add
                </span>

                Daftar Anggota
            </a>
        @endauth
    </nav>
</aside>
