<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class MeminjamController extends Controller
{
    public function store(
        Request $request,
        Buku $buku
    ): RedirectResponse {
        $user = $request->user();
        $anggota = $user?->anggota;

        abort_unless($user && $anggota, 403);

        $userAktif = in_array(
            strtolower((string) $user->status),
            ['aktif', 'active'],
            true
        );

        $anggotaAktif = in_array(
            strtolower((string) $anggota->status),
            ['aktif', 'active'],
            true
        );

        if (! $userAktif || ! $anggotaAktif) {
            return back()->with(
                'error',
                'Akun anggota tidak aktif.'
            );
        }

        $validated = $request->validate([
            'jumlah' => [
                'required',
                'integer',
                'min:1',
            ],

            'tanggal_rencana_pengambilan' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'catatan' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ], [
            'jumlah.required' => 'Jumlah buku wajib diisi.',
            'jumlah.integer' => 'Jumlah buku harus berupa angka.',
            'jumlah.min' => 'Jumlah buku minimal 1.',

            'tanggal_rencana_pengambilan.required' =>
                'Tanggal rencana pengambilan wajib diisi.',

            'tanggal_rencana_pengambilan.after_or_equal' =>
                'Tanggal pengambilan tidak boleh sebelum hari ini.',
        ]);

        DB::transaction(function () use (
            $validated,
            $anggota,
            $buku
        ): void {
            $bukuTerkunci = Buku::query()
                ->lockForUpdate()
                ->findOrFail($buku->id);

            $jumlah = (int) $validated['jumlah'];

            if ((int) $bukuTerkunci->stok < $jumlah) {
                throw ValidationException::withMessages([
                    'jumlah' =>
                        "Stok tidak mencukupi. Stok tersedia: {$bukuTerkunci->stok}.",
                ]);
            }

            $sudahMeminjam = DetailPeminjaman::query()
                ->where('buku_id', $bukuTerkunci->id)
                ->whereHas(
                    'peminjaman',
                    function ($query) use ($anggota): void {
                        $query
                            ->where('anggota_id', $anggota->id)
                            ->whereIn('status', [
                                'diajukan',
                                'disetujui',
                                'dipinjam',
                                'terlambat',
                            ]);
                    }
                )
                ->exists();

            if ($sudahMeminjam) {
                throw ValidationException::withMessages([
                    'jumlah' =>
                        'Buku ini masih terdapat dalam transaksi aktif Anda.',
                ]);
            }

            $peminjaman = Peminjaman::create([
                'anggota_id' => $anggota->id,
                'kode_peminjaman' => $this->generateCode(),
                'tanggal_pengajuan' => now()->toDateString(),
                'tanggal_rencana_pengambilan' =>
                    $validated['tanggal_rencana_pengambilan'],
                'tanggal_pinjam' => null,
                'tanggal_jatuh_tempo' => null,
                'tanggal_kembali' => null,
                'status' => 'diajukan',
                'catatan_anggota' =>
                    filled($validated['catatan'] ?? null)
                        ? $validated['catatan']
                        : null,
            ]);

            DetailPeminjaman::create([
                'peminjaman_id' => $peminjaman->id,
                'buku_id' => $bukuTerkunci->id,
                'jumlah' => $jumlah,
            ]);

            // Stok langsung berkurang ketika anggota klik Meminjam.
            $bukuTerkunci->decrement('stok', $jumlah);
        });

        return redirect()
            ->route('katalog.show', $buku)
            ->with(
                'success',
                'Permintaan meminjam buku berhasil dikirim. Stok buku telah diperbarui.'
            );
    }

    private function generateCode(): string
    {
        do {
            $code = 'PJM-'
                . now()->format('YmdHis')
                . '-'
                . Str::upper(Str::random(5));
        } while (
            Peminjaman::query()
                ->where('kode_peminjaman', $code)
                ->exists()
        );

        return $code;
    }
}
