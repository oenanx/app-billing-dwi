<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class RptLogPostpaid21 implements FromView, WithColumnWidths, WithColumnFormatting
{
    protected $data;
	
    public function __construct($data)
	{
       $this->data = $data;
    }

    public function view(): View
    {
        return view('exports.rptlogpostpaid21', [
            'data' => $this->data
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20, //tgl_hit
            'B' => 40, //noapi_id
            'C' => 15, //status_hit
            'D' => 20, //data_input
            'E' => 18, //status
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
