<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Buku;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function create(Buku $buku): View
    {
        $tersediaBooking = $this->hitungTersediaBooking($buku);

        return view('frontend.pages.booking-buku', [
            'buku' => $buku,
            'tersediaBooking' => $tersediaBooking,
        ]);
    }

    public function store(
        Request $request,
        Buku $buku
    ): RedirectResponse {
        $validated = $request->validate([
            'nama_pemesan' => [
                'required',
                'string',
                'max:255',
            ],
            'nomor_telepon' => [
                'required',
                'string',
                'max:30',
                'regex:/^[0-9+\-\s]+$/',
            ],
            'jumlah' => [
                'required',
                'integer',
                'min:1',
            ],
            'catatan' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ], [
            'nama_pemesan.required' => 'Nama pemesan wajib diisi.',
            'nomor_telepon.required' => 'Nomor telepon wajib diisi.',
            'nomor_telepon.regex' => 'Format nomor telepon tidak valid.',
            'jumlah.required' => 'Jumlah buku wajib diisi.',
            'jumlah.min' => 'Jumlah buku minimal 1.',
        ]);

        $booking = DB::transaction(function () use (
            $validated,
            $buku
        ): Booking {
            $bukuTerkunci = Buku::query()
                ->lockForUpdate()
                ->findOrFail($buku->id);

            $jumlahTerbooking = Booking::query()
                ->where('buku_id', $bukuTerkunci->id)
                ->whereIn('status', [
                    'menunggu',
                    'disetujui',
                ])
                ->sum('jumlah');

            $tersediaBooking = max(
                0,
                (int) $bukuTerkunci->stok
                - (int) $jumlahTerbooking
            );

            if ((int) $validated['jumlah'] > $tersediaBooking) {
                throw ValidationException::withMessages([
                    'jumlah' => "Jumlah buku yang tersedia untuk booking hanya {$tersediaBooking}.",
                ]);
            }

            return Booking::query()->create([
                'buku_id' => $bukuTerkunci->id,
                'nama_pemesan' => $validated['nama_pemesan'],
                'nomor_telepon' => $validated['nomor_telepon'],
                'jumlah' => $validated['jumlah'],
                'status' => 'menunggu',
                'catatan' => $validated['catatan'] ?? null,
            ]);
        });

        return redirect()->route(
            'booking.success',
            ['kodeBooking' => $booking->kode_booking]
        );
    }

    public function success(string $kodeBooking): View
    {
        $booking = Booking::query()
            ->with('buku')
            ->where('kode_booking', $kodeBooking)
            ->firstOrFail();

        return view('frontend.pages.booking-success', [
            'booking' => $booking,
        ]);
    }

    private function hitungTersediaBooking(Buku $buku): int
    {
        $jumlahTerbooking = Booking::query()
            ->where('buku_id', $buku->id)
            ->whereIn('status', [
                'menunggu',
                'disetujui',
            ])
            ->sum('jumlah');

        return max(
            0,
            (int) $buku->stok - (int) $jumlahTerbooking
        );
    }
}
