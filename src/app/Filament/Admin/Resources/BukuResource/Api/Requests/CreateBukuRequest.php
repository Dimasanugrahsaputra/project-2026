<?php

namespace App\Filament\Admin\Resources\BukuResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBukuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'kode_buku' => 'required',
			'judul_buku' => 'required',
			'kategori_buku_id' => 'required',
			'rak_buku_id' => 'required',
			'penulis' => 'required',
			'penerbit' => 'required',
			'tahun_terbit' => 'required',
			'isbn' => 'required',
			'stok' => 'required',
			'cover' => 'required',
			'deskripsi' => 'required|string'
		];
    }
}
