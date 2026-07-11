<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ForgotPassword extends Component
{
    public string $email = '';

    public ?string $successMessage = null;

    public function sendResetLink(): void
    {
        $this->validate([
            'email' => [
                'required',
                'email',
            ],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $status = Password::sendResetLink([
            'email' => $this->email,
        ]);

        if ($status === Password::RESET_LINK_SENT) {
            $this->resetErrorBag();

            $this->successMessage =
                'Tautan reset password berhasil dikirim. '
                . 'Silakan periksa kotak masuk atau folder spam email kamu.';

            return;
        }

        if ($status === Password::RESET_THROTTLED) {
            $this->addError(
                'email',
                'Permintaan terlalu sering. Tunggu beberapa saat lalu coba kembali.'
            );

            return;
        }

        /*
         * Gunakan respons umum supaya sistem tidak memberitahukan
         * apakah email terdaftar atau tidak.
         */
        $this->successMessage =
            'Jika email tersebut terdaftar, tautan reset password '
            . 'akan dikirim ke alamat email tersebut.';
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
