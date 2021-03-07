<?php

namespace App\Services;

use App\Product;
use App\Provider;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DetailCardExporter
{
    public function export($detailCards, $startDate, $endDate, $transport) 
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $colums = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK', 'AL', 'AM');
        foreach($colums as $column) {
            $sheet->getColumnDimension($column)->setWidth(2.71);
        }

        $sheet->mergeCells("B3:AM3");
        $sheet->getStyle('B3')->getFont()->setName('Arial');
        $sheet->getStyle('B3')->getFont()->setSize(12);
        $sheet->getStyle('B3')->getFont()->setBold(true);
        $sheet->getStyle("B3:AM3")->getBorders()->getBottom()->setBorderStyle('thick');
        
        $sheet->setCellValue('B3', sprintf("Карточка списанных товаров с %s г. по %s г., для транспорта: %s",$startDate, $endDate, $transport));

        $sheet->mergeCells("B5:F5");
        $sheet->getStyle('B5')->getFont()->setName('Arial');
        $sheet->getStyle('B5')->getFont()->setSize(9);
        $sheet->setCellValue('B5', 'Транспорт:');

        $sheet->mergeCells("G5:K5");
        $sheet->getStyle('G5')->getFont()->setName('Arial');
        $sheet->getStyle('G5')->getFont()->setSize(9);
        $sheet->getStyle('G5')->getFont()->setBold(true);
        $sheet->setCellValue('G5', sprintf("%s",  $transport));

        

        $sheet->mergeCells("B7:C8");
        $sheet->getStyle('B7')->getFont()->setName('Arial');
        $sheet->getStyle('B7')->getFont()->setSize(9);
        $sheet->getStyle('B7')->getFont()->setBold(true);
        $sheet->getStyle("B7")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("B7")->getAlignment()->setVertical('center');
        $sheet->setCellValue('B7', '№');

        $sheet->mergeCells("D7:T8");
        $sheet->getStyle('D7')->getFont()->setName('Arial');
        $sheet->getStyle('D7')->getFont()->setSize(9);
        $sheet->getStyle('D7')->getFont()->setBold(true);
        $sheet->getStyle("D7")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("D7")->getAlignment()->setVertical('center');
        $sheet->setCellValue('D7', 'Товар');

        $sheet->mergeCells("U7:W8");
        $sheet->getStyle('U7')->getFont()->setName('Arial');
        $sheet->getStyle('U7')->getFont()->setSize(9);
        $sheet->getStyle('U7')->getFont()->setBold(true);
        $sheet->getStyle("U7")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("U7")->getAlignment()->setVertical('center');
        $sheet->setCellValue('U7', 'Кол-во');

        $sheet->mergeCells("X7:AA8");
        $sheet->getStyle('X7')->getFont()->setName('Arial');
        $sheet->getStyle('X7')->getFont()->setSize(9);
        $sheet->getStyle('X7')->getFont()->setBold(true);
        $sheet->getStyle("X7")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("X7")->getAlignment()->setVertical('center');
        $sheet->setCellValue('X7', 'Списано');
        
        $sheet->mergeCells("AB7:AE8");
        $sheet->getStyle('AB7')->getFont()->setName('Arial');
        $sheet->getStyle('AB7')->getFont()->setSize(9);
        $sheet->getStyle('AB7')->getFont()->setBold(true);
        $sheet->getStyle("AB7")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("AB7")->getAlignment()->setVertical('center');
        $sheet->setCellValue('AB7', 'Ед.');

        $sheet->mergeCells("AF7:AI8");
        $sheet->getStyle('AF7')->getFont()->setName('Arial');
        $sheet->getStyle('AF7')->getFont()->setSize(9);
        $sheet->getStyle('AF7')->getFont()->setBold(true);
        $sheet->getStyle("AF7")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("AF7")->getAlignment()->setVertical('center');
        $sheet->setCellValue('AF7', 'Цена');

        $sheet->mergeCells("AJ7:AM8");
        $sheet->getStyle('AJ7')->getFont()->setName('Arial');
        $sheet->getStyle('AJ7')->getFont()->setSize(9);
        $sheet->getStyle('AJ7')->getFont()->setBold(true);
        $sheet->getStyle("AJ7")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("AJ7")->getAlignment()->setVertical('center');
        $sheet->setCellValue('AJ7', 'Сумма');

        
        $qty = 0;
        $sum = 0;
        foreach($detailCards as $detailCard){
            $sheet->mergeCells(sprintf("B%d:C%d",$qty+9,$qty+9));
            $sheet->getStyle(sprintf("B%d",$qty+9))->getFont()->setName('Arial');
            $sheet->getStyle(sprintf("B%d",$qty+9))->getFont()->setSize(8);
            $sheet->setCellValue(sprintf("B%d",$qty+9), $qty+1);
            $sheet->mergeCells(sprintf("D%d:T%d",$qty+9,$qty+9));
            $sheet->getStyle(sprintf("D%d",$qty+9))->getFont()->setName('Arial');
            $sheet->getStyle(sprintf("D%d",$qty+9))->getFont()->setSize(8);
            $sheet->setCellValue(sprintf("D%s",$qty+9), $detailCard->product->title);
            $sheet->mergeCells(sprintf("U%d:W%d",$qty+9,$qty+9));
            $sheet->getStyle(sprintf("U%d",$qty+9))->getFont()->setName('Arial');
            $sheet->getStyle(sprintf("U%d",$qty+9))->getFont()->setSize(8);
            $sheet->setCellValue(sprintf("U%d",$qty+9), $detailCard->product->qty);
            $sheet->mergeCells(sprintf("X%d:AA%d",$qty+9,$qty+9));
            $sheet->getStyle(sprintf("X%d",$qty+9))->getFont()->setName('Arial');
            $sheet->getStyle(sprintf("X%d",$qty+9))->getFont()->setSize(8);
            $sheet->setCellValue(sprintf("X%s",$qty+9), $detailCard->qty);
            $sheet->mergeCells(sprintf("AB%d:AE%d",$qty+9,$qty+9));
            $sheet->getStyle(sprintf("AB%d",$qty+9))->getFont()->setName('Arial');
            $sheet->getStyle(sprintf("AB%d",$qty+9))->getFont()->setSize(8);
            $sheet->setCellValue(sprintf("AB%d",$qty+9), $detailCard->product->unit);
            $sheet->getStyle(sprintf("AB%d",$qty+9))->getAlignment()->setHorizontal('left');
            $sheet->mergeCells(sprintf("AF%d:AI%d",$qty+9,$qty+9));
            $sheet->getStyle(sprintf("AF%d",$qty+9))->getFont()->setName('Arial');
            $sheet->getStyle(sprintf("AF%d",$qty+9))->getFont()->setSize(8);
            $sheet->setCellValue(sprintf("AF%d",$qty+9), $detailCard->product->price);
            $sheet->mergeCells(sprintf("AJ%d:AM%d",$qty+9,$qty+9));
            $sheet->getStyle(sprintf("AJ%d",$qty+9))->getFont()->setName('Arial');
            $sheet->getStyle(sprintf("AJ%d",$qty+9))->getFont()->setSize(8);
            $sheet->setCellValue(sprintf("AJ%d",$qty+9), $detailCard->product->price*$detailCard->qty);
            $sum += $detailCard->product->price*$detailCard->qty;
            $qty++;
        }
        $border = array(
            'borders'=>array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => array('rgb' => '000000')
                ),
                'inside' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                )
            )
        );
        $sheet->getStyle(sprintf("B8:AM%d",$qty+8))->applyFromArray($border);
        $spreadsheet->getActiveSheet()->getStyle('B7:AM8')
    ->getFill()->getStartColor()->setARGB('FFFF0000');

        $sheet->mergeCells(sprintf("AH%d:AI%d",$qty+10,$qty+10));
        $sheet->getStyle(sprintf("AH%d",$qty+10))->getFont()->setName('Arial');
        $sheet->getStyle(sprintf("AH%d",$qty+10))->getFont()->setSize(9);
        $sheet->getStyle(sprintf("AH%d",$qty+10))->getFont()->setBold(true);
        $sheet->setCellValue(sprintf("AH%d",$qty+10), "Итого:");

        $sheet->mergeCells(sprintf("AJ%d:AM%d",$qty+10,$qty+10));
        $sheet->getStyle(sprintf("AJ%d",$qty+10))->getFont()->setName('Arial');
        $sheet->getStyle(sprintf("AJ%d",$qty+10))->getFont()->setSize(9);
        $sheet->getStyle(sprintf("AJ%d",$qty+10))->getFont()->setBold(true);
        $sheet->setCellValue(sprintf("AJ%d",$qty+10), $sum);

        $sheet->mergeCells(sprintf("B%d:AM%d",$qty+13,$qty+13));
        $sheet->getStyle(sprintf("B%d",$qty+13))->getFont()->setName('Arial');
        $sheet->getStyle(sprintf("B%d",$qty+13))->getFont()->setSize(9);
        $sheet->setCellValue(sprintf("B%d",$qty+13), sprintf("Всего наименований %d на сумму %d руб.",$qty, $sum));

        $sheet->mergeCells(sprintf("B%d:AM%d",$qty+14,$qty+14));
        $sheet->getStyle(sprintf("B%d",$qty+14))->getFont()->setName('Arial');
        $sheet->getStyle(sprintf("B%d",$qty+14))->getFont()->setSize(9);
        $sheet->getStyle(sprintf("B%d",$qty+14))->getFont()->setBold(true);
        $sheet->setCellValue(sprintf("B%d",$qty+14),  $sum);
        $sheet->getStyle(sprintf("B%d",$qty+14))->getAlignment()->setHorizontal('left');

        $sheet->mergeCells(sprintf("B%d:AM%d",$qty+15,$qty+15));
        $sheet->getStyle(sprintf("B%d:AM%d",$qty+15,$qty+15))->getBorders()->getBottom()->setBorderStyle('thick');
       
        $writer = new Xlsx($spreadsheet);
        $writer->save('card.xlsx');
    }
}

