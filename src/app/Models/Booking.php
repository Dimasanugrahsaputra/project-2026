<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $fillable = [
        'kode_booking',
        'buku_id',
        'nama_pemesan',
        'nomor_telepon',
        'jumlah',
        'tanggal_booking',
        'tanggal_kedaluwarsa',
        'status',
        'catatan',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'tanggal_booking' => 'date',
        'tanggal_kedaluwarsa' => 'date',
    ];

    protected static function booted(): void
    {
        static::creating(function (Booking $booking): void {
            if (blank($booking->kode_booking)) {
                do {
                    $kode = 'BKG-'
                        . now()->format('YmdHis')
                        . '-'
                        . strtoupper(Str::random(4));
                } while (
                    static::query()
                        ->where('kode_booking', $kode)
                        ->exists()
                );

                $booking->kode_booking = $kode;
            }

            if (blank($booking->tanggal_booking)) {
                $booking->tanggal_booking = now()->toDateString();
            }

            if (blank($booking->tanggal_kedaluwarsa)) {
                $booking->tanggal_kedaluwarsa = now()
                    ->addDays(2)
                    ->toDateString();
            }

            if (blank($booking->status)) {
                $booking->status = 'menunggu';
            }
        });
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}
