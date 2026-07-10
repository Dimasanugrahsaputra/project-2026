<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MemberLogin extends Component
{
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    protected function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'string',
            ],

            'remember' => [
                'boolean',
            ],
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'email' => 'email',
            'password' => 'password',
        ];
    }

    public function authenticate(): void
    {
        $validated = $this->validate();

        $authenticated = Auth::attempt(
            [
                'email' => $validated['email'],
                'password' => $validated['password'],
            ],
            $validated['remember']
        );

        if (! $authenticated) {
            $this->addError(
                'email',
                'Email atau password tidak sesuai.'
            );

            return;
        }

        request()->session()->regenerate();

        $user = Auth::user();

        if (! $user instanceof User) {
            $this->logoutInvalidUser();

            $this->addError(
                'email',
                'Akun tidak valid.'
            );

            return;
        }

        $user->loadMissing('anggota');

        if (! $user->isActiveAnggota()) {
            $this->logoutInvalidUser();

            $this->addError(
                'email',
                'Akun bukan anggota aktif.'
            );

            return;
        }

        $this->redirect('/', navigate: true);
    }

    private function logoutInvalidUser(): void
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }

    public function render()
    {
        return view('livewire.auth.member-login');
    }
}
