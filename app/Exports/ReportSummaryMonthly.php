<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class ReportSummaryMonthly implements FromView, WithColumnWidths, WithColumnFormatting
{
    protected $params;
    protected $data;
	
    public function __construct($params, $data)
	{
		$this->params = $params;
		$this->data = $data;
    }

    public function view(): View
    {
        return view('exports.rptSummaryMonthly', [
			'params' => $this->params,
            'data' => $this->data
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,            
            'B' => 50,            
            'C' => 50,            
            'D' => 15,            
            'E' => 25,            
        ];
    }
    
    public function columnFormats(): array
    {
        return [
			'A' => DataType::TYPE_STRING,
            'B' => DataType::TYPE_STRING,
            'C' => DataType::TYPE_STRING,
			'D' => NumberFormat::FORMAT_NUMBER,
			'E' => NumberFormat::FORMAT_DATE_YYYYMMDD,
        ];
    }
}
