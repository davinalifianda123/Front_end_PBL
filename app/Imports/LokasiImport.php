<?php

namespace App\Imports;

use App\Models\Lokasi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LokasiImport implements ToModel, WithHeadingRow
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
        return new Lokasi([
            'id_toko' => $this->nullify($row['id_toko']),
            'id_gudang' => $this->nullify($row['id_gudang']),
        ]);
    }
}
