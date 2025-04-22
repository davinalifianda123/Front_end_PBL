<?php

namespace App\Http\Requests\ReturBarang;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReturBarangRequest extends FormRequest
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
            'id_user' => [
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
            'id_status_retur' => [
                'required',
                'exists:status_returs,id',
            ],
            'id_pengiriman_barang' => [
                'required',
                'exists:pengiriman_barangs,id',
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
            'id_user.required' => 'Penanggung jawab harus diisi.',
            'id_user.exists' => 'Penanggung jawab tidak valid.',

            'tanggal_retur.required' => 'Tanggal retur harus diisi.',
            'tanggal_retur.date' => 'Format tanggal retur tidak valid.',

            'alasan_retur.required' => 'Alasan retur harus diisi.',
            'alasan_retur.string' => 'Alasan retur harus berupa string.',
            
            'id_pengiriman_barang.required' => 'Pengiriman barang harus dipilih.',
            'id_pengiriman_barang.exists' => 'Pengiriman barang yang dipilih tidak valid.',

            'id_status_retur.required' => 'Status retur harus dipilih.',
            'id_status_retur.exists' => 'Status retur yang dipilih tidak valid.',
        ];
    }
}
