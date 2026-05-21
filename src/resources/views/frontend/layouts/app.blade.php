<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital</title>

    <script src="https://cdn.tailwindcss.com"></script>

    @livewireStyles
</head>
<body class="bg-slate-50 text-slate-800">

    <header class="bg-white border-b sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('frontend.home') }}" class="text-2xl font-bold text-blue-600">
                Perpustakaan
            </a>

            <nav class="flex items-center gap-6">
                <a href="{{ route('frontend.home') }}"
                   class="font-medium {{ request()->routeIs('frontend.home') ? 'text-blue-600' : 'text-slate-600 hover:text-blue-600' }}">
                    Beranda
                </a>

                <a href="{{ route('frontend.buku') }}"
                   class="font-medium {{ request()->routeIs('frontend.buku*') ? 'text-blue-600' : 'text-slate-600 hover:text-blue-600' }}">
                    Daftar Buku
                </a>

                <a href="{{ url('/admin') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Login Admin
                </a>
            </nav>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="bg-slate-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-6 py-8 text-center">
            <p>&copy; {{ date('Y') }} Perpustakaan Digital. All rights reserved.</p>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
