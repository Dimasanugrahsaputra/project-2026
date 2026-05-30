<?php

namespace App\Filament\Admin\Resources\BukuResource\Api\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BukuTransformer extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kode_buku' => $this->kode_buku,
            'judul_buku' => $this->judul_buku,
            'judul' => $this->judul_buku,

            'kategori_buku_id' => $this->kategori_buku_id,
            'kategori' => [
                'id' => $this->kategoriBuku?->id,
                'nama_kategori' => $this->kategoriBuku?->nama_kategori,
            ],

            'rak_buku_id' => $this->rak_buku_id,
            'rak' => [
                'id' => $this->rakBuku?->id,
                'nama_rak' => $this->rakBuku?->nama_rak,
            ],

            'penulis' => $this->penulis,
            'penerbit' => $this->penerbit,
            'tahun_terbit' => $this->tahun_terbit,
            'isbn' => $this->isbn,
            'stok' => $this->stok,
            'cover' => $this->cover,
            'cover_url' => $this->cover ? asset('storage/' . $this->cover) : null,
            'deskripsi' => $this->deskripsi,

            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}   
