<?php

namespace App\Filament\Admin\Resources\AnggotaResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnggotaRequest extends FormRequest
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
			'user_id' => 'required',
			'kode_anggota' => 'required',
			'tanggal_bergabung' => 'required|date',
			'status' => 'required',
			'nama_lengkap' => 'required',
			'email' => 'required',
			'no_hp' => 'required',
			'alamat' => 'required|string'
		];
    }
}
