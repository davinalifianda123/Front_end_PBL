<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rules\Password;
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
        return [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
            'role_id' => ['required', 'numeric', 'exists:roles,id'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Kolom nama wajib diisi.',
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
            'role_id.exists' => 'Role yang dipilih tidak ditemukan.',
        ];
    }
}
