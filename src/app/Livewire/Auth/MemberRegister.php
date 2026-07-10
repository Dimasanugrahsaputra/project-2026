<?php

namespace App\Livewire\Auth;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class MemberRegister extends Component
{
    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $address = '';

    public string $password = '';

    public string $password_confirmation = '';

    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
                'unique:anggotas,email',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'address' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'name' => 'nama lengkap',
            'email' => 'email',
            'phone' => 'nomor HP',
            'address' => 'alamat',
            'password' => 'password',
        ];
    }

    public function register(): void
    {
        $validated = $this->validate();

        $role = $this->resolveDatabaseValue(
            'users',
            'role',
            ['anggota', 'member', 'user']
        );

        $userStatus = $this->resolveDatabaseValue(
            'users',
            'status',
            ['aktif', 'active']
        );

        $anggotaStatus = $this->resolveDatabaseValue(
            'anggotas',
            'status',
            ['aktif', 'active']
        );

        $user = DB::transaction(function () use (
            $validated,
            $role,
            $userStatus,
            $anggotaStatus
        ): User {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'phone' => filled($validated['phone'])
                    ? $validated['phone']
                    : null,
                'address' => filled($validated['address'])
                    ? $validated['address']
                    : null,
                'role' => $role,
                'status' => $userStatus,
            ]);

            Anggota::create([
                'user_id' => $user->id,
                'kode_anggota' => $this->generateMemberCode(),
                'nama_lengkap' => $validated['name'],
                'email' => $validated['email'],
                'no_hp' => filled($validated['phone'])
                    ? $validated['phone']
                    : null,
                'alamat' => filled($validated['address'])
                    ? $validated['address']
                    : null,
                'tanggal_bergabung' => now()->toDateString(),
                'status' => $anggotaStatus,
            ]);

            return $user;
        });

        Auth::login($user);

        request()->session()->regenerate();

        session()->flash(
            'success',
            'Registrasi anggota berhasil. Selamat datang!'
        );

        $this->redirectRoute(
            'katalog.index',
            navigate: true
        );
    }

    private function generateMemberCode(): string
    {
        do {
            $code = 'AGT-'
                . now()->format('Ymd')
                . '-'
                . Str::upper(Str::random(6));
        } while (
            Anggota::query()
                ->where('kode_anggota', $code)
                ->exists()
        );

        return $code;
    }

    /**
     * Memilih nilai enum yang tersedia pada database MariaDB.
     */
    private function resolveDatabaseValue(
        string $table,
        string $column,
        array $preferredValues
    ): string {
        $columnInformation = DB::selectOne(
            "SHOW COLUMNS FROM `{$table}` LIKE '{$column}'"
        );

        if (! $columnInformation) {
            throw ValidationException::withMessages([
                'email' => "Kolom {$table}.{$column} tidak ditemukan.",
            ]);
        }

        $type = strtolower(
            (string) ($columnInformation->Type ?? '')
        );

        /*
         * Untuk VARCHAR, gunakan nilai pilihan pertama.
         */
        if (! str_starts_with($type, 'enum(')) {
            return $preferredValues[0];
        }

        preg_match_all(
            "/'([^']+)'/",
            $type,
            $matches
        );

        $availableValues = $matches[1] ?? [];

        foreach ($preferredValues as $value) {
            if (in_array($value, $availableValues, true)) {
                return $value;
            }
        }

        throw ValidationException::withMessages([
            'email' =>
                "Kolom {$table}.{$column} belum mendukung nilai anggota aktif.",
        ]);
    }

    public function render()
    {
        return view('livewire.auth.member-register');
    }
}
