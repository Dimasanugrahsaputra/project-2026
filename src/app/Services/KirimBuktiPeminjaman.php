<?php

namespace App\Services;

use App\Mail\BuktiPeminjamanMail;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class KirimBuktiPeminjaman
{
    public function kirim(Peminjaman $peminjaman): bool
    {
        $peminjaman->refresh();

        $peminjaman->load([
            'anggota.user',
            'detailPeminjamans.buku',
        ]);

        $status = strtolower(
            trim((string) $peminjaman->status)
        );

        if ($status !== 'dipinjam') {
            return false;
        }

        if ($peminjaman->bukti_peminjaman_dikirim_at) {
            return false;
        }

        if ($peminjaman->detailPeminjamans->isEmpty()) {
            Log::warning(
                'Bukti peminjaman belum dikirim karena detail buku kosong.',
                [
                    'peminjaman_id' => $peminjaman->id,
                    'kode_peminjaman' => $peminjaman->kode_peminjaman,
                ]
            );

            return false;
        }

        $email = $peminjaman
            ->anggota
            ?->user
            ?->email;

        if (blank($email)) {
            Log::warning(
                'Bukti peminjaman belum dikirim karena email anggota kosong.',
                [
                    'peminjaman_id' => $peminjaman->id,
                    'kode_peminjaman' => $peminjaman->kode_peminjaman,
                ]
            );

            return false;
        }

        try {
            Mail::to($email)->send(
                new BuktiPeminjamanMail($peminjaman)
            );

            $peminjaman->updateQuietly([
                'bukti_peminjaman_dikirim_at' => now(),
            ]);

            Log::info(
                'Bukti peminjaman berhasil dikirim.',
                [
                    'peminjaman_id' => $peminjaman->id,
                    'kode_peminjaman' => $peminjaman->kode_peminjaman,
                    'email' => $email,
                    'jumlah_detail' => $peminjaman
                        ->detailPeminjamans
                        ->count(),
                ]
            );

            return true;
        } catch (Throwable $exception) {
            Log::error(
                'Bukti peminjaman gagal dikirim.',
                [
                    'peminjaman_id' => $peminjaman->id,
                    'kode_peminjaman' => $peminjaman->kode_peminjaman,
                    'email' => $email,
                    'error' => $exception->getMessage(),
                ]
            );

            return false;
        }
    }
}
