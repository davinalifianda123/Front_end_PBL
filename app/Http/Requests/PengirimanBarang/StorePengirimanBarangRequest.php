<?php

namespace App\Http\Requests\PengirimanBarang;

use App\Rules\BelongsToGudangOrToko;
use Illuminate\Foundation\Http\FormRequest;

class StorePengirimanBarangRequest extends FormRequest
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
        $rules = [
            'id_asal_barang' => [
                'required',
                new BelongsToGudangOrToko,
            ],
            'id_tujuan_pengiriman' => [
                'required',
                new BelongsToGudangOrToko,
            ],
            'tanggal_pengiriman' => [
                'required',
                'date'
            ],
            'id_kurir' => [
                'required',
                'exists:kurirs,id'
            ],
            'barang_id' => [
                'required',
                'array'
            ],
            'barang_id.*' => [
                'exists:barangs,id'
            ],
            'jumlah' => [
                'required',
                'array'
            ],
            'jumlah.*' => [
                'required',
                'numeric',
                'min:1'
            ],
        ];

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'tanggal_pengiriman.required' => 'Tanggal pengiriman harus diisi.',
            'tanggal_pengiriman.date' => 'Format tanggal pengiriman tidak valid.',

            'id_kurir.required' => 'Kurir harus dipilih.',
            'id_kurir.exists' => 'Kurir yang dipilih tidak valid.',

            'barang_id.required' => 'Setidaknya satu barang harus dipilih.',
            'barang_id.array' => 'Barang yang dipilih harus berupa array.',
            'barang_id.*.exists' => 'Salah satu atau lebih barang yang dipilih tidak valid.',

            'jumlah.required' => 'Jumlah barang harus diisi.',
            'jumlah.array' => 'Jumlah barang harus berupa array.',
            'jumlah.*.required' => 'Jumlah untuk setiap barang harus diisi.',
            'jumlah.*.numeric' => 'Jumlah untuk setiap barang harus berupa angka.',
            'jumlah.*.min' => 'Jumlah untuk setiap barang minimal harus 1.',
        ];
    }
}
