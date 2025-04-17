<?php

namespace App\Imports;

use App\Models\Toko;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TokoImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Toko([
            'nama_toko' => $row['nama_toko'],
            'id_jenis_toko' => $row['id_jenis_toko'],
            'alamat' => $row['alamat'],
            'no_telepon' => $row['no_telepon'],
        ]);
    }
}
