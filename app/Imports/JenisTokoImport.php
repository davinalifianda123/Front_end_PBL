<?php

namespace App\Imports;

use App\Models\JenisToko;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JenisTokoImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new JenisToko([
            'nama_jenis_toko' => $row['nama_jenis_toko'],
        ]);
    }
}
