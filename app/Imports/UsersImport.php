<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    private function nullify($value)
    {
        $nullValues = ['NULL', '', '#N/A', 'null', 'N/A', '-'];
        return in_array($value, $nullValues, true) ? null : $value;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'nama_user' => $row['nama_user'],
            'email' => $row['email'],
            'password' => Hash::make($row['password']),
            'id_role' => $row['id_role'],
            'id_gudang' => $this->nullify($row['id_gudang']),
            'id_toko' => $this->nullify($row['id_toko']),
        ]);
    }
}
