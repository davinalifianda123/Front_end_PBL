<?php

namespace App\Imports;

use App\Models\Gudang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GudangImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Gudang([
            'nama_gudang' => $row['nama_gudang'],
            'alamat' => $row['alamat'],
        ]);
    }
}
