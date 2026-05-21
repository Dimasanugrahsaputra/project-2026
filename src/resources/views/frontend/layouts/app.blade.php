<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital</title>

    <script src="https://cdn.tailwindcss.com"></script>

    @livewireStyles
</head>
<body class="bg-slate-50 text-slate-900 antialiased">

    <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/90 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <a href="{{ route('frontend.home') }}" class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-200">
                    📚
                </div>
                <span class="text-xl font-bold text-blue-600">Perpustakaan</span>
            </a>

            <nav class="hidden items-center gap-8 md:flex">
                <a href="{{ route('frontend.home') }}"
                   class="{{ request()->routeIs('frontend.home') ? 'text-blue-600' : 'text-slate-700' }} font-medium hover:text-blue-600">
                    Beranda
                </a>

                <a href="{{ route('frontend.buku') }}"
                   class="{{ request()->routeIs('frontend.buku*') ? 'text-blue-600' : 'text-slate-700' }} font-medium hover:text-blue-600">
                    Daftar Buku
                </a>

                <a href="#tentang" class="font-medium text-slate-700 hover:text-blue-600">
                    Tentang
                </a>

                <a href="#kontak" class="font-medium text-slate-700 hover:text-blue-600">
                    Kontak
                </a>
            </nav>

            <a href="/admin"
               class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700">
                Login Admin
            </a>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer id="kontak" class="mt-20 bg-slate-950 text-white">
        <div class="mx-auto grid max-w-7xl gap-10 px-6 py-12 md:grid-cols-4">
            <div>
                <div class="mb-4 flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-600">
                        📚
                    </div>
                    <h3 class="text-xl font-bold">Perpustakaan</h3>
                </div>
                <p class="text-sm leading-6 text-slate-300">
                    Sistem perpustakaan digital untuk melihat koleksi buku dengan mudah dan cepat.
                </p>
            </div>

            <div>
                <h4 class="mb-4 font-semibold">Navigasi</h4>
                <div class="space-y-3 text-sm text-slate-300">
                    <a href="{{ route('frontend.home') }}" class="block hover:text-white">Beranda</a>
                    <a href="{{ route('frontend.buku') }}" class="block hover:text-white">Daftar Buku</a>
                    <a href="#tentang" class="block hover:text-white">Tentang</a>
                </div>
            </div>

            <div>
                <h4 class="mb-4 font-semibold">Informasi</h4>
                <div class="space-y-3 text-sm text-slate-300">
                    <p>Cara Peminjaman</p>
                    <p>Syarat & Ketentuan</p>
                    <p>Kebijakan Privasi</p>
                </div>
            </div>

            <div>
                <h4 class="mb-4 font-semibold">Kontak</h4>
                <div class="space-y-3 text-sm text-slate-300">
                    <p>📧 perpustakaan@gmail.com</p>
                    <p>📱 +62 812-3456-7890</p>
                    <p>📍 Jakarta, Indonesia</p>
                </div>
            </div>
        </div>

        <div class="border-t border-slate-800 py-5 text-center text-sm text-slate-400">
            © {{ date('Y') }} Perpustakaan Digital. All rights reserved.
        </div>
    </footer>

    @livewireScripts
</body>
</html>
