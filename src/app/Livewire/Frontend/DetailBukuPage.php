<?php

namespace App\Livewire\Frontend;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Throwable;

class DetailBukuPage extends Component
{
    public Buku $buku;

    public string $nama_lengkap = '';
    public string $email = '';
    public string $no_hp = '';
    public string $alamat = '';
    public int $jumlah = 1;
    public string $tanggal_pinjam = '';
    public string $tanggal_jatuh_tempo = '';

    public ?string $successMessage = null;
    public ?string $errorMessage = null;

    public function mount(Buku $buku): void
    {
        $this->buku = $buku;

        $this->tanggal_pinjam = now()->format('Y-m-d');
        $this->tanggal_jatuh_tempo = now()->addDays(7)->format('Y-m-d');
    }

    public function booking()
    {
        $this->resetErrorBag();

        $this->successMessage = null;
        $this->errorMessage = null;

        $this->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'no_hp' => ['required', 'string', 'max:30'],
            'alamat' => ['required', 'string', 'max:1000'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'tanggal_pinjam' => ['required', 'date'],
            'tanggal_jatuh_tempo' => ['required', 'date', 'after_or_equal:tanggal_pinjam'],
        ]);

        if ($this->jumlah > (int) $this->buku->stok) {
            $this->addError('booking', 'Stok buku tidak cukup.');
            return null;
        }

        try {
            $peminjaman = DB::transaction(function () {
                $userId = auth()->id() ?? User::query()->value('id');

                $anggota = Anggota::query()
                    ->where('email', $this->email)
                    ->first();

                if (! $anggota) {
                    $anggota = Anggota::create([
                        'user_id' => $userId,
                        'kode_anggota' => 'AGT-' . now()->format('YmdHis') . '-' . random_int(100, 999),
                        'nama_lengkap' => $this->nama_lengkap,
                        'email' => $this->email,
                        'no_hp' => $this->no_hp,
                        'alamat' => $this->alamat,
                        'tanggal_bergabung' => now()->format('Y-m-d'),
                        'status' => 'aktif',
                    ]);
                } else {
                    $anggota->update([
                        'user_id' => $anggota->user_id ?? $userId,
                        'nama_lengkap' => $this->nama_lengkap,
                        'no_hp' => $this->no_hp,
                        'alamat' => $this->alamat,
                        'status' => 'aktif',
                    ]);
                }

                $peminjamanData = [
                    'kode_peminjaman' => 'PMJ-' . now()->format('YmdHis') . '-' . random_int(100, 999),
                    'anggota_id' => $anggota->id,
                    'tanggal_pinjam' => $this->tanggal_pinjam,
                    'tanggal_jatuh_tempo' => $this->tanggal_jatuh_tempo,
                    'status' => 'dipinjam',
                ];

                if (Schema::hasColumn('peminjamans', 'petugas_id')) {
                    $peminjamanData['petugas_id'] = $userId;
                }

                $peminjaman = Peminjaman::create($peminjamanData);

                DetailPeminjaman::create([
                    'peminjaman_id' => $peminjaman->id,
                    'buku_id' => $this->buku->id,
                    'jumlah' => $this->jumlah,
                ]);

                $this->buku->decrement('stok', $this->jumlah);

                return $peminjaman;
            });

            return redirect()->route('frontend.booking.success', $peminjaman);
        } catch (Throwable $e) {
            report($e);

            $this->addError('booking', 'Booking gagal: ' . $e->getMessage());

            return null;
        }
    }

    public function render()
    {
        return view('frontend.pages.detail-buku')
            ->layout('frontend.layouts.app');
    }
}
