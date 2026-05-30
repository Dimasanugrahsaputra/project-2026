<?php

namespace App\Filament\Admin\Resources\DetailPeminjamanResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDetailPeminjamanRequest extends FormRequest
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
			'peminjaman_id' => 'required',
			'buku_id' => 'required',
			'jumlah' => 'required'
		];
    }
}
