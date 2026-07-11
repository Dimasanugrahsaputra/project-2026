@php
    $anggota = $peminjaman->anggota;
    $user = $anggota?->user;

    $namaAnggota = $user?->name
        ?? $anggota?->nama_lengkap
        ?? 'Anggota';

    $tanggalPinjam = $peminjaman->tanggal_pinjam
        ? \Illuminate\Support\Carbon::parse(
            $peminjaman->tanggal_pinjam
        )->format('d/m/Y')
        : '-';

    $tanggalJatuhTempo = $peminjaman->tanggal_jatuh_tempo
        ? \Illuminate\Support\Carbon::parse(
            $peminjaman->tanggal_jatuh_tempo
        )->format('d/m/Y')
        : '-';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Bukti Peminjaman Buku</title>
</head>

<body style="
    margin: 0;
    padding: 0;
    background-color: #f1f5f9;
    font-family: Arial, Helvetica, sans-serif;
    color: #0f172a;
">
    <div style="
        max-width: 640px;
        margin: 0 auto;
        padding: 32px 16px;
    ">
        <div style="
            overflow: hidden;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background-color: #ffffff;
        ">
            <div style="
                padding: 28px;
                background-color: #2563eb;
                color: #ffffff;
                text-align: center;
            ">
                <h1 style="
                    margin: 0;
                    font-size: 24px;
                ">
                    Bukti Peminjaman Buku
                </h1>

                <p style="
                    margin: 8px 0 0;
                    font-size: 14px;
                ">
                    Perpustakaan Online
                </p>
            </div>

            <div style="padding: 28px;">
                <p style="
                    margin-top: 0;
                    font-size: 15px;
                    line-height: 1.7;
                ">
                    Halo <strong>{{ $namaAnggota }}</strong>,
                </p>

                <p style="
                    font-size: 15px;
                    line-height: 1.7;
                ">
                    Buku telah diserahkan kepada kamu dan transaksi
                    peminjaman telah tercatat dengan rincian berikut.
                </p>

                <table style="
                    width: 100%;
                    margin-top: 24px;
                    border-collapse: collapse;
                    font-size: 14px;
                ">
                    <tbody>
                        <tr>
                            <td style="
                                width: 42%;
                                padding: 12px;
                                border: 1px solid #e2e8f0;
                                background-color: #f8fafc;
                                font-weight: bold;
                            ">
                                Kode Peminjaman
                            </td>

                            <td style="
                                padding: 12px;
                                border: 1px solid #e2e8f0;
                            ">
                                {{ $peminjaman->kode_peminjaman }}
                            </td>
                        </tr>

                        <tr>
                            <td style="
                                padding: 12px;
                                border: 1px solid #e2e8f0;
                                background-color: #f8fafc;
                                font-weight: bold;
                            ">
                                Nama Anggota
                            </td>

                            <td style="
                                padding: 12px;
                                border: 1px solid #e2e8f0;
                            ">
                                {{ $namaAnggota }}
                            </td>
                        </tr>

                        <tr>
                            <td style="
                                padding: 12px;
                                border: 1px solid #e2e8f0;
                                background-color: #f8fafc;
                                font-weight: bold;
                            ">
                                Tanggal Pinjam
                            </td>

                            <td style="
                                padding: 12px;
                                border: 1px solid #e2e8f0;
                            ">
                                {{ $tanggalPinjam }}
                            </td>
                        </tr>

                        <tr>
                            <td style="
                                padding: 12px;
                                border: 1px solid #e2e8f0;
                                background-color: #f8fafc;
                                font-weight: bold;
                            ">
                                Tanggal Jatuh Tempo
                            </td>

                            <td style="
                                padding: 12px;
                                border: 1px solid #e2e8f0;
                            ">
                                {{ $tanggalJatuhTempo }}
                            </td>
                        </tr>

                        <tr>
                            <td style="
                                padding: 12px;
                                border: 1px solid #e2e8f0;
                                background-color: #f8fafc;
                                font-weight: bold;
                            ">
                                Status
                            </td>

                            <td style="
                                padding: 12px;
                                border: 1px solid #e2e8f0;
                            ">
                                Dipinjam
                            </td>
                        </tr>
                    </tbody>
                </table>

                <h2 style="
                    margin-top: 28px;
                    margin-bottom: 12px;
                    font-size: 18px;
                ">
                    Daftar Buku
                </h2>

                <table style="
                    width: 100%;
                    border-collapse: collapse;
                    font-size: 14px;
                ">
                    <thead>
                        <tr>
                            <th style="
                                padding: 12px;
                                border: 1px solid #e2e8f0;
                                background-color: #f8fafc;
                                text-align: left;
                            ">
                                Buku
                            </th>

                            <th style="
                                width: 90px;
                                padding: 12px;
                                border: 1px solid #e2e8f0;
                                background-color: #f8fafc;
                                text-align: center;
                            ">
                                Jumlah
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($details as $detail)
                            <tr>
                                <td style="
                                    padding: 12px;
                                    border: 1px solid #e2e8f0;
                                ">
                                    <strong>
                                        {{ $detail->buku?->judul
                                            ?? $detail->buku?->judul_buku
                                            ?? '-' }}
                                    </strong>

                                    @if ($detail->buku?->kode_buku)
                                        <br>

                                        <span style="
                                            color: #64748b;
                                            font-size: 12px;
                                        ">
                                            {{ $detail->buku->kode_buku }}
                                        </span>
                                    @endif
                                </td>

                                <td style="
                                    padding: 12px;
                                    border: 1px solid #e2e8f0;
                                    text-align: center;
                                ">
                                    {{ $detail->jumlah }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="2"
                                    style="
                                        padding: 12px;
                                        border: 1px solid #e2e8f0;
                                        text-align: center;
                                    "
                                >
                                    Detail buku tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div style="
                    margin-top: 24px;
                    padding: 16px;
                    border-radius: 10px;
                    background-color: #fff7ed;
                    color: #9a3412;
                    font-size: 13px;
                    line-height: 1.6;
                ">
                    Harap kembalikan buku paling lambat tanggal
                    <strong>{{ $tanggalJatuhTempo }}</strong>.
                    Keterlambatan dapat menimbulkan denda.
                </div>

                <p style="
                    margin-top: 28px;
                    margin-bottom: 0;
                    font-size: 14px;
                    line-height: 1.7;
                ">
                    Terima kasih,<br>
                    <strong>Admin Perpustakaan</strong>
                </p>
            </div>
        </div>

        <p style="
            margin-top: 18px;
            text-align: center;
            color: #64748b;
            font-size: 12px;
        ">
            Email ini dikirim otomatis oleh sistem perpustakaan.
        </p>
    </div>
</body>
</html>
