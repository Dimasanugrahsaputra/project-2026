<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="Sistem Informasi Peminjaman Buku Online"
    >

    <title>
        @yield('title', 'Perpustakaan Digital')
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])
</head>

<body class="bg-slate-50 text-slate-900 antialiased">
    <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-6 py-4">
            <a
                href="{{ route('katalog.index') }}"
                class="flex items-center gap-3"
            >
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-600 text-xl font-bold text-white shadow-sm">
                    P
                </div>

                <div>
                    <div class="text-lg font-bold text-slate-900">
                        Perpustakaan Digital
                    </div>

                    <div class="text-xs text-slate-500">
                        Sistem Informasi Peminjaman Buku Online
                    </div>
                </div>
            </a>

            <nav class="hidden items-center gap-6 md:flex">
                <a
                    href="{{ route('katalog.index') }}"
                    @class([
                        'text-sm font-semibold transition',
                        'text-blue-600' => request()->routeIs('katalog.index'),
                        'text-slate-600 hover:text-blue-600' => ! request()->routeIs('katalog.index'),
                    ])
                >
                    Katalog Buku
                </a>
            </nav>

            <a
                href="{{ url('/admin') }}"
                class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-bold text-white transition hover:bg-blue-700"
            >
                Login Admin
            </a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="border-t border-slate-800 bg-slate-900">
        <div class="mx-auto max-w-6xl px-6 py-6 text-center text-sm text-slate-300">
            © {{ date('Y') }} Perpustakaan Digital —
            Sistem Informasi Peminjaman Buku Online
        </div>
    </footer>
</body>
</html>
