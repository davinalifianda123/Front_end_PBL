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
        $isPusatValue = $row['is_pusat'];

        $isPusatBoolean = false;
        if (is_string($isPusatValue)) {
            $isPusatBoolean = strtolower($isPusatValue) === 'true';
        } elseif (is_numeric($isPusatValue)) {
            $isPusatBoolean = (bool) $isPusatValue; // 1 akan jadi true, 0 jadi false
        } elseif (is_bool($isPusatValue)) {
            $isPusatBoolean = $isPusatValue;
        }

        return new Gudang([
            'nama_gudang' => $row['nama_gudang'],
            'alamat' => $row['alamat'],
            'is_pusat' => $isPusatBoolean,
        ]);
    }
}
