<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class RptLogPostpaid18 implements FromView, WithColumnWidths, WithColumnFormatting
{
    protected $data;
	
    public function __construct($data)
	{
       $this->data = $data;
    }

    public function view(): View
    {
        return view('exports.rptlogpostpaid18', [
            'data' => $this->data
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,            
            'B' => 45,            
            'C' => 15,            
            'D' => 20, //phoneno input        
            'E' => 20, //nik input
            'F' => 15, //Match / Not Match
        ];
    }
    
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_YYYYMMDD,
            'B' => DataType::TYPE_STRING,
            'C' => DataType::TYPE_STRING,
            'D' => NumberFormat::FORMAT_NUMBER,
            'E' => DataType::TYPE_STRING,
            'F' => DataType::TYPE_STRING,
        ];
    }
}
