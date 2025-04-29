<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePenerimaanDiCabangRequest extends FormRequest
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
            'id_barang' => 'required|exists:barangs,id',
            'id_jenis_penerimaan' => 'required|exists:jenis_penerimaans,id',
            'id_asal_barang' => 'required|exists:gudang_dan_tokos,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
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
            'id_barang.required' => 'ID Barang harus diisi.',
            'id_barang.exists' => 'ID Barang tidak valid.',

            'id_jenis_penerimaan.required' => 'ID Jenis Penerimaan harus diisi.',
            'id_jenis_penerimaan.exists' => 'ID Jenis Penerimaan tidak valid.',

            'id_asal_barang.required' => 'ID Asal Barang harus diisi.',
            'id_asal_barang.exists' => 'ID Asal Barang tidak valid.',

            'jumlah.required' => 'Jumlah harus diisi.',
            'jumlah.integer' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah minimal 1.',

            'tanggal.required' => 'Tanggal harus diisi.',
            'tanggal.date' => 'Tanggal tidak valid.',
            
            'keterangan.max' => 'Keterangan maksimal 255 karakter.',
        ];
    }    
}
