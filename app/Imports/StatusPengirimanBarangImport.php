<?php

namespace App\Imports;

use App\Models\StatusPengirimanBarang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StatusPengirimanBarangImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new StatusPengirimanBarang([
            'nama_status' => $row['nama_status'],
        ]);
    }
}
