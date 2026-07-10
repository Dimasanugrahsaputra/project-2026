<div class="w-full">
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-slate-900">
            Login Anggota
        </h1>

        <p class="mt-2 text-sm text-slate-600">
            Masuk menggunakan akun anggota perpustakaan.
        </p>
    </div>

    <form
        wire:submit="authenticate"
        class="space-y-5"
    >
        <div>
            <label
                for="email"
                class="mb-1 block text-sm font-medium text-slate-700"
            >
                Email
            </label>

            <input
                id="email"
                type="email"
                wire:model="email"
                autocomplete="email"
                placeholder="anggota@email.com"
                class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
            >

            @error('email')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label
                for="password"
                class="mb-1 block text-sm font-medium text-slate-700"
            >
                Password
            </label>

            <input
                id="password"
                type="password"
                wire:model="password"
                autocomplete="current-password"
                placeholder="Masukkan password"
                class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
            >

            @error('password')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <label class="flex items-center gap-2 text-sm text-slate-700">
            <input
                type="checkbox"
                wire:model="remember"
                class="rounded border-slate-300 text-blue-600 focus:ring-blue-500"
            >

            Ingat saya
        </label>

        <button
            type="submit"
            wire:loading.attr="disabled"
            wire:target="authenticate"
            class="w-full rounded-lg bg-blue-600 px-4 py-3 font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
        >
            <span wire:loading.remove wire:target="authenticate">
                Login
            </span>

            <span wire:loading wire:target="authenticate">
                Memproses...
            </span>
        </button>
    </form>

    <div class="mt-6 text-center text-sm text-slate-600">
        Belum memiliki akun?

        <a
            href="{{ route('anggota.register') }}"
            class="font-semibold text-emerald-600 hover:underline"
        >
            Daftar Anggota
        </a>
    </div>

    <div class="mt-3 text-center">
        <a
            href="{{ route('katalog.index') }}"
            class="text-sm font-medium text-blue-600 hover:underline"
        >
            Kembali ke katalog
        </a>
    </div>
</div>
