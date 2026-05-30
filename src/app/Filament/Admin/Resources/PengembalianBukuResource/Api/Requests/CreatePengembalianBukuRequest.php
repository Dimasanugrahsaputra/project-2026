<?php

namespace App\Filament\Admin\Resources\PengembalianBukuResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePengembalianBukuRequest extends FormRequest
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
			'kode_pengembalian' => 'required',
			'peminjaman_id' => 'required',
			'petugas_id' => 'required',
			'tanggal_pengembalian' => 'required|date',
			'jumlah_hari_terlambat' => 'required',
			'status' => 'required',
			'catatan' => 'required|string'
		];
    }
}
