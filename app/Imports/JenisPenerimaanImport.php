<?php

namespace App\Imports;

use App\Models\JenisPenerimaan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JenisPenerimaanImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new JenisPenerimaan([
            'nama_jenis_penerimaan' => $row['nama_jenis_penerimaan'],
        ]);
    }
}
