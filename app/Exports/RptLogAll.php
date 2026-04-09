<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class RptLogAll implements FromView, WithColumnWidths, WithColumnFormatting
{
    protected $data;
	
    public function __construct($data)
	{
       $this->data = $data;
    }

    public function view(): View
    {
        return view('exports.rptlogAll', [
            'data' => $this->data
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 50, //company_name
            'B' => 45, //product
            'C' => 20, //periode
            'D' => 15, //billingtype
            'E' => 20, //tot_sukses
            'F' => 20, //tot_failed
        ];
    }
    
    public function columnFormats(): array
    {
        return [
            'A' => DataType::TYPE_STRING,
            'B' => DataType::TYPE_STRING,
            'C' => DataType::TYPE_STRING,
            'D' => DataType::TYPE_STRING,
            'E' => NumberFormat::FORMAT_NUMBER,
            'F' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
