<?php

namespace App\Http\Requests\Role;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
            'nama_role' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('roles')->ignore($this->role),
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
            'nama_role.required' => 'Nama role harus diisi.',
            'nama_role.unique' => 'Nama role sudah digunakan.',
            'nama_role.max' => 'Nama role maksimal 255 karakter.',
        ];
    }
}
