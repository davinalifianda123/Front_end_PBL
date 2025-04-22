<?php

namespace App\Http\Requests\ReturBarang;

use Illuminate\Foundation\Http\FormRequest;

class StoreReturBarangRequest extends FormRequest
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
            'id_penanggung_jawab' => [
                'required',
                'exists:users,id',
            ],
            'tanggal_retur' => [
                'required',
                'date',
            ],
            'alasan_retur' => [
                'required',
                'string',
            ],
            'id_pengiriman_barang' => [
                'required',
                'exists:pengiriman_barangs,id',
            ],
            'id_barang' => [
                'required',
                'array',
            ],
            'id_barang.*' => [
                'exists:barangs,id'
            ],
            'jumlah_barang_retur' => [
                'required',
                'array',
            ],
            'jumlah_barang_retur.*' => [
                'required',
                'integer',
                'min:1',
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
            'id_penanggung_jawab.required' => 'Penanggung jawab harus diisi.',
            'id_penanggung_jawab.exists' => 'Penanggung jawab tidak valid.',

            'tanggal_retur.required' => 'Tanggal retur harus diisi.',
            'tanggal_retur.date' => 'Format tanggal retur tidak valid.',

            'alasan_retur.required' => 'Alasan retur harus diisi.',
            'alasan_retur.string' => 'Alasan retur harus berupa string.',
            
            'id_pengiriman_barang.required' => 'Pengiriman barang harus dipilih.',
            'id_pengiriman_barang.exists' => 'Pengiriman barang yang dipilih tidak valid.',

            'id_kurir.required' => 'Kurir harus dipilih.',
            'id_kurir.exists' => 'Kurir yang dipilih tidak valid.',

            'id_barang.required' => 'Setidaknya satu barang harus dipilih.',
            'id_barang.array' => 'Barang yang dipilih harus berupa array.',
            'id_barang.*.exists' => 'Salah satu atau lebih barang yang dipilih tidak valid.',

            'jumlah_barang_retur.required' => 'Jumlah barang yang diretur harus diisi.',
            'jumlah_barang_retur.array' => 'Jumlah barang yang diretur harus berupa array.',
            'jumlah_barang_retur.*.required' => 'Jumlah untuk setiap barang yang diretur harus diisi.',
            'jumlah_barang_retur.*.numeric' => 'Jumlah untuk setiap barang yang diretur harus berupa angka.',
            'jumlah_barang_retur.*.min' => 'Jumlah untuk setiap barang yang diretur minimal harus 1.',
        ];
    }
}
