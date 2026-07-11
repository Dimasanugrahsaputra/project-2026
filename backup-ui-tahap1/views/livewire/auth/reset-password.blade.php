<div class="min-h-screen bg-slate-50">
    <div class="mx-auto flex min-h-screen max-w-7xl items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
                <div class="mb-8 text-center">
                    <h1 class="text-2xl font-bold text-slate-900">
                        Buat Password Baru
                    </h1>

                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Masukkan password baru untuk akun anggota kamu.
                    </p>
                </div>

                <form wire:submit="resetPassword" class="space-y-5">
                    <div>
                        <label
                            for="email"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Email
                        </label>

                        <input
                            wire:model="email"
                            id="email"
                            type="email"
                            autocomplete="email"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                        >

                        @error('email')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label
                            for="password"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Password Baru
                        </label>

                        <input
                            wire:model="password"
                            id="password"
                            type="password"
                            autocomplete="new-password"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                        >

                        @error('password')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label
                            for="password_confirmation"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Konfirmasi Password Baru
                        </label>

                        <input
                            wire:model="password_confirmation"
                            id="password_confirmation"
                            type="password"
                            autocomplete="new-password"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                        >
                    </div>

                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        class="flex w-full items-center justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        <span wire:loading.remove wire:target="resetPassword">
                            Simpan Password Baru
                        </span>

                        <span wire:loading wire:target="resetPassword">
                            Menyimpan...
                        </span>
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a
                        href="/login-anggota"
                        wire:navigate
                        class="text-sm font-semibold text-blue-600 hover:text-blue-700"
                    >
                        Kembali ke halaman login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>