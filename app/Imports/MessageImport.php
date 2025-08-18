<?php

namespace App\Imports;

use App\Models\Mod_Files;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
//use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MessageImport implements ToModel, WithStartRow
{
     /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
	public function startRow(): int
    {
        return 2;
    }
	
    public function model(array $row)
    {
        return new Mod_Files([
            'no_ktp' => $row[0],
            'no_telp' => $row[1], 
        ]);
    }
}
