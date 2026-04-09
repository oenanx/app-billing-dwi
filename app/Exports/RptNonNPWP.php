<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class RptNonNPWP implements FromView, WithStyles, ShouldAutoSize, WithColumnWidths, WithColumnFormatting
{
    protected $periode;
    protected $data;
	
    public function __construct($periode,$data)
	{
       $this->periode = $periode;
       $this->data = $data;
    }

    public function view(): View
    {
        return view('exports.rptNonNPWP', [
            'periode' => $this->periode,
            'data' => $this->data
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true);
		
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->getStyle('B3')->getFont()->setBold(true);
        $sheet->getStyle('C3')->getFont()->setBold(true);
        $sheet->getStyle('D3')->getFont()->setBold(true);
        $sheet->getStyle('E3')->getFont()->setBold(true);
        $sheet->getStyle('F3')->getFont()->setBold(true);
        $sheet->getStyle('G3')->getFont()->setBold(true);
        $sheet->getStyle('H3')->getFont()->setBold(true);
    }
	
    public function columnWidths(): array
    {
        return [
            'A' => 10, //PERIOD
            'B' => 20, //CUSTOMERNO
            'C' => 25, //INVOICENO
            'D' => 45, //CUSTOMERNAME
            'E' => 20, //NPWP NO
            'F' => 130, //ADDRESS_NPWP
            'G' => 15, //TOTALAMOUNT
            'H' => 15, //TOTALVAT
        ];
    }
    
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'B' => DataType::TYPE_STRING,
            'C' => DataType::TYPE_STRING,
            'D' => DataType::TYPE_STRING,
            'E' => DataType::TYPE_STRING,
            'F' => DataType::TYPE_STRING,
            'G' => NumberFormat::FORMAT_NUMBER,
            'H' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
