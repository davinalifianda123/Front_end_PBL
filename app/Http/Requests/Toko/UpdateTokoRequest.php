<?php

namespace App\Http\Requests\Toko;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTokoRequest extends FormRequest
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
            'nama_toko' => [
                'required',
                'string',
                'max:255',
            ],
            'id_jenis_toko' => [ 
                'nullable',
                'exists:jenis_tokos,id',
            ],
            'alamat' => [
                'required', 
                'string', 
                Rule::unique('tokos')->ignore($this->toko),
            ],
            'no_telepon' => [
                'required', 
                'string'
            ]
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama_toko.required' => 'Nama toko harus diisi.',
            'nama_toko.max' => 'Nama toko maksimal 255 karakter.',
            'alamat.required' => 'Nama alamat harus diisi.',
            'no_telepon.required' => 'No telepon harus diisi.',
        ];
    }
}
