<?php

namespace App\Http\Requests\User;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
        $roleId = $this->input('id_role');
        $role = Role::find($roleId);

        $rules = [
            'nama_user' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'id_role' => 'required|exists:roles,id',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string',
            'penempatan' => 'nullable|string',
            'id_gudang' => 'nullable|numeric',
            'id_toko' => 'nullable|numeric',
        ];
        
        if ($role && in_array($role->nama_role, ['Supplier', 'Buyer'])) {
            $rules['alamat'] = 'required|string';
            $rules['no_telepon'] = 'required|string';
        }

        if ($role && $role->nama_role === 'Staff') {
            $rules['penempatan'] = 'required|string';

            if ($this->input('id_gudang') != null) {
                $rules['id_gudang'] = 'required|numeric|exists:gudangs,id';
            }

            if ($this->input('id_toko') != null) {
                $rules['id_toko'] = 'required|numeric|exists:tokos,id';
            }
        }
        
        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama_user.required' => 'Kolom nama wajib diisi.',
            'email.required' => 'Kolom email wajib diisi.',
            'email.email' => 'Silakan masukkan alamat email yang valid.',
            'email.unique' => 'Alamat email ini sudah digunakan.',
            'password.min' => 'Kata sandi harus memiliki panjang minimal 8 karakter.',
            'password.required' => 'Kolom password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.mixed' => 'Kata sandi harus mengandung kombinasi huruf besar dan huruf kecil.',
            'password.numbers' => 'Kata sandi harus menyertakan setidaknya satu angka.',
            'password.symbols' => 'Kata sandi harus mengandung setidaknya satu simbol dari berikut: !@#$%&*()-_+=',
            'password.uncompromised' => 'Kata sandi yang anda masukan terlalu umum, atau pernah bocor di internet, silahkan gunakan kata sandi yang lain.',
            'id_role.exists' => 'Role yang dipilih tidak ditemukan.',
            'alamat.required' => 'Alamat harus diisi untuk role Supplier atau Buyer.',
            'no_telepon.required' => 'No. Telepon harus diisi untuk role Supplier atau Buyer.',
            'penempatan.required' => 'Jenis Lokasi Penempatan harus diisi.',
            'id_gudang.required' => 'Lokasi Gudang harus diisi.',
            'id_gudang.exists' => 'Lokasi Gudang yang dipilih tidak ditemukan',
            'id_toko.required' => 'Lokasi Toko harus diisi',
            'id_toko.exists' => 'Lokasi Toko yang dipilih tidak ditemukan',
        ];
    }
}
