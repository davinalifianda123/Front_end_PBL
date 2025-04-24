<?php

namespace App\Http\Requests\GudangDanToko;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGudangDanTokoRequest extends FormRequest
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
            'nama_gudang' => [
                'required',
                'string',
                'max:255',
                Rule::unique('gudang_dan_tokos')->ignore($this->gudang), 
            ],
            'alamat' => [
                'required',
                'string',
            ],
            'no_telepon' => [
                'required',
                'string',
            ],
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
            'nama_gudang.required' => 'Nama gudang harus diisi.',
            'nama_gudang.max' => 'Nama gudang maksimal 255 karakter.',
            
            'alamat.required' => 'Alamat harus diisi.',

            'no_telepon.required' => 'No telepon harus diisi.',
        ];
    }
}
