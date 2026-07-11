@props([
    'title' => 'Sistem Perpustakaan',
    'active' => null,
])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        {{ $title }} -
        {{ config('app.name', 'Sistem Perpustakaan') }}
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])

    <link
        rel="stylesheet"
        href="{{ asset('css/library.css') }}"
    >

    <script
        defer
        src="{{ asset('js/library.js') }}"
    ></script>

    @livewireStyles
    @stack('styles')
</head>

<body>
    <div class="page-shell">
        <x-public-navbar :active="$active" />

        {{ $slot }}

        <x-public-footer />
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>
