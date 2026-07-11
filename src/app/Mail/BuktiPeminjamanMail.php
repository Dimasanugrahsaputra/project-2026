<?php

namespace App\Mail;

use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BuktiPeminjamanMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Peminjaman $peminjaman
    ) {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bukti Peminjaman Buku - '
                . $this->peminjaman->kode_peminjaman
        );
    }

    public function content(): Content
    {
        /*
         * Data detail diambil saat email benar-benar dirender,
         * bukan saat object Mailable pertama kali dibuat.
         */
        $this->peminjaman->loadMissing([
            'anggota.user',
        ]);

        $details = DetailPeminjaman::query()
            ->with('buku')
            ->where(
                'peminjaman_id',
                $this->peminjaman->id
            )
            ->get();

        return new Content(
            view: 'emails.peminjaman.bukti-peminjaman',
            with: [
                'peminjaman' => $this->peminjaman,
                'details' => $details,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
