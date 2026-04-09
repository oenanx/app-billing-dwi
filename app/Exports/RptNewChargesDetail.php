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

class RptNewChargesDetail implements FromView, WithStyles, ShouldAutoSize, WithColumnWidths, WithColumnFormatting
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
        return view('exports.rptNewChargesDetail', [
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
        $sheet->getStyle('I3')->getFont()->setBold(true);
        $sheet->getStyle('J3')->getFont()->setBold(true);
        $sheet->getStyle('K3')->getFont()->setBold(true);
        $sheet->getStyle('L3')->getFont()->setBold(true);
        $sheet->getStyle('M3')->getFont()->setBold(true);
        $sheet->getStyle('N3')->getFont()->setBold(true);
        $sheet->getStyle('O3')->getFont()->setBold(true);
        $sheet->getStyle('P3')->getFont()->setBold(true);
    }
	
    public function columnWidths(): array
    {
        return [
            'A' => 15, //PERIOD
            'B' => 20, //CUSTOMERNO
            'C' => 45, //CUSTOMERNAME
            'D' => 20, //ACTIVATIONDATE			
            'E' => 20, //USAGEADJUSTMENT
            'F' => 20, //TOTALDISCOUNT
            'G' => 20, //PREVIOUSBALANCE
            'H' => 25, //BALANCEADJUSTMENT			
            'I' => 20, //PREVIOUSPAYMENT
            'J' => 20, //TOTALAMOUNT
            'K' => 20, //REVENUE
            'L' => 20, //TOTALVAT
            'M' => 20, //NEWCHARGE
            'N' => 20, //TOTALUSAGE
            'O' => 20, //NEWBALANCE
            'P' => 25, //SALESAGENTNAME
        ];
    }
    
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'B' => DataType::TYPE_STRING,
            'C' => DataType::TYPE_STRING,
            'D' => NumberFormat::FORMAT_DATE_YYYYMMDD,
            'E' => NumberFormat::FORMAT_NUMBER,
            'F' => NumberFormat::FORMAT_NUMBER,
            'G' => NumberFormat::FORMAT_NUMBER,
            'H' => NumberFormat::FORMAT_NUMBER,
            'I' => NumberFormat::FORMAT_NUMBER,
            'J' => NumberFormat::FORMAT_NUMBER,
            'K' => NumberFormat::FORMAT_NUMBER,
            'L' => NumberFormat::FORMAT_NUMBER,
            'M' => NumberFormat::FORMAT_NUMBER,
            'N' => NumberFormat::FORMAT_NUMBER,
            'O' => NumberFormat::FORMAT_NUMBER,
            'P' => DataType::TYPE_STRING,
        ];
    }
}
