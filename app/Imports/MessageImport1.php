<?php

namespace App\Imports;

use App\Models\Mod_Files1;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
//use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MessageImport1 implements ToModel, WithStartRow
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
        return new Mod_Files1([
            'no_telp' => $row[0], 
            'result' => $row[1],
        ]);
    }
}
