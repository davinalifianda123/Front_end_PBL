<?php

namespace App\Imports;

use App\Models\Kurir;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KurirImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Kurir([
            'nama_kurir' => $row['nama_kurir']
        ]);
    }
}
