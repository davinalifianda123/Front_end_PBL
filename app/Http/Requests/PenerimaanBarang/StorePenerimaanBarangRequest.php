<?php

namespace App\Http\Requests\PenerimaanBarang;

use App\Rules\BelongsToGudangOrToko;
use Illuminate\Foundation\Http\FormRequest;

class StorePenerimaanBarangRequest extends FormRequest
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
            'id_asal_barang' => [
                'required',
                new BelongsToGudangOrToko,
            ],
            'id_tujuan_pengiriman' => [
                'required',
                new BelongsToGudangOrToko,
            ],
            'tanggal_penerimaan' => [
                'required',
                'date',
            ],
            'barang_id' => [
                'required',
                'array',
                'min:1',
            ],
            'barang_id.*' => [
                'required',
                'exists:barangs,id'
            ],
            'jumlah' => [
                'required',
                'array',
                'min:1'
            ],
            'jumlah.*' => [
                'required',
                'numeric',
                'min:1',
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
            'id_asal_barang.required' => 'Asal lokasi barang yang dikirim harus diisi.',
            'id_tujuan_pengiriman.required' => 'Tujuan pengiriman barang yang dikirim harus diisi.',

            'tanggal_penerimaan.required' => 'Tanggal penerimaan harus diisi.',
            'tanggal_penerimaan.date' => 'Format tanggal penerimaan tidak valid.',

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
