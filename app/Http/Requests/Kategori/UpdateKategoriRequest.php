<?php

namespace App\Http\Requests\Kategori;

use App\Models\KategoriBarang;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateKategoriRequest extends FormRequest
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
            'nama_kategori_barang' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kategori_barangs')->ignore($this->kategori_barang),
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
            'nama_kategori_barang.required' => 'Nama kategori barang harus diisi.',
            'nama_kategori_barang.max' => 'Nama kategori barang maksimal 255 karakter.',
        ];
    }
}
