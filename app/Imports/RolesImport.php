<?php

namespace App\Imports;

use App\Models\Role;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RolesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        /* 
            When using WithHeadingRow with a single column, you need to reference the column by its header name instead of its index. This is why you're getting the "Undefined array key 0" error.

            The key point is that when you implement WithHeadingRow, Laravel Excel transforms your data so that:

            The keys in your $row array are the column headers from your Excel file
            You must access data using $row['column_header_name'] instead of $row[0]
         */

        return new Role([
            'nama_role' => $row['nama_role'],
        ]);
    }
}
