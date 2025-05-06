<?php

namespace App\Imports;

use App\Models\SatuanBerat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SatuanBeratImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SatuanBerat([
            'nama_satuan_berat' => $row['nama_satuan_berat'],
        ]);
    }
}
