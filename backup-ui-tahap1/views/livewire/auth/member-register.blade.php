<div class="w-full">
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-slate-900">
            Daftar Anggota
        </h1>

        <p class="mt-2 text-sm text-slate-600">
            Buat akun untuk mengakses layanan peminjaman buku.
        </p>
    </div>

    <form
        wire:submit="register"
        class="space-y-4"
    >
        <div>
            <label
                for="name"
                class="mb-1 block text-sm font-medium text-slate-700"
            >
                Nama Lengkap
            </label>

            <input
                id="name"
                type="text"
                wire:model="name"
                autocomplete="name"
                placeholder="Masukkan nama lengkap"
                class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
            >

            @error('name')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

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
                for="phone"
                class="mb-1 block text-sm font-medium text-slate-700"
            >
                Nomor HP
            </label>

            <input
                id="phone"
                type="text"
                wire:model="phone"
                autocomplete="tel"
                placeholder="08xxxxxxxxxx"
                class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
            >

            @error('phone')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label
                for="address"
                class="mb-1 block text-sm font-medium text-slate-700"
            >
                Alamat
            </label>

            <textarea
                id="address"
                wire:model="address"
                rows="3"
                placeholder="Masukkan alamat"
                class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
            ></textarea>

            @error('address')
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
                autocomplete="new-password"
                placeholder="Minimal 8 karakter"
                class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
            >

            @error('password')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label
                for="password_confirmation"
                class="mb-1 block text-sm font-medium text-slate-700"
            >
                Konfirmasi Password
            </label>

            <input
                id="password_confirmation"
                type="password"
                wire:model="password_confirmation"
                autocomplete="new-password"
                placeholder="Ulangi password"
                class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
            >
        </div>

        <button
            type="submit"
            wire:loading.attr="disabled"
            class="w-full rounded-lg bg-emerald-600 px-4 py-3 font-semibold text-white transition hover:bg-emerald-700 disabled:cursor-not-allowed disabled:opacity-50"
        >
            <span wire:loading.remove>
                Daftar Anggota
            </span>

            <span wire:loading>
                Membuat akun...
            </span>
        </button>
    </form>

    <div class="mt-6 text-center text-sm text-slate-600">
        Sudah memiliki akun?

        <a
            href="{{ route('anggota.login') }}"
            class="font-semibold text-blue-600 hover:underline"
        >
            Login Anggota
        </a>
    </div>

    <div class="mt-3 text-center">
        <a
            href="{{ route('katalog.index') }}"
            class="text-sm font-medium text-slate-600 hover:text-blue-600"
        >
            Kembali ke katalog
        </a>
    </div>
</div>
