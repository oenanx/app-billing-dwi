<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class RptLogTrial17 implements FromView, WithColumnWidths, WithColumnFormatting
{
    protected $data;
	
    public function __construct($data)
	{
       $this->data = $data;
    }

    public function view(): View
    {
        return view('exports.rptlogtrial17', [
            'data' => $this->data
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,            
            'B' => 40,            
            'C' => 15,            
            'D' => 20,            
            'E' => 15, //Age           
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
        ];
    }
}
