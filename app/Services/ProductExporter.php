<?php

namespace App\Services;

use App\Product;
use App\Provider;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProductExporter
{
    public function export($products) 
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $colums = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK');
        foreach($colums as $column) {
            $sheet->getColumnDimension($column)->setWidth(2.71);
        }

        $sheet->mergeCells("B3:AF3");
        $sheet->getStyle('B3')->getFont()->setName('Arial');
        $sheet->getStyle('B3')->getFont()->setSize(14);
        $sheet->getStyle('B3')->getFont()->setBold(true);
        $sheet->getStyle("B3:AF3")->getBorders()->getBottom()->setBorderStyle('thick');
        #$sheet->setCellValue('B3', "Приходная накладная № А-0707 от 16 апреля 2020 г.");
        setlocale(LC_ALL, 'ru_RU');
        $day =strftime("%d",  $products[0]->date );
        $month = strftime("%m",  $products[0]->date );
        $year = strftime("%Y",  $products[0]->date );
        switch ($month) {
            case "01":
                $month = "января";
                break;
            case "02":
                $month = "февраля";
                break;
            case "03":
                $month = "марта";
                break;
            case "04":
                $month = "апреля";
                    break;
            case "05":
                $month = "мая";
                break;
            case "06":
                $month = "июня";
                break;
            case "07":
                $month = "июля";
                break;
            case "08":
                $month = "августа";
                    break;
            case "09":
                $month = "сентября";
                break;
            case "10":
                $month = "октября";
                break;
            case "11":
                $month = "ноября";
                break;
            case "12":
                $month = "декабря";
                    break;
        }
        $sheet->setCellValue('B3', sprintf("Приходная накладная %s от %s %s %s г.",$products[0]->waybillTitle, $day, $month, $year));

        $sheet->mergeCells("B5:F5");
        $sheet->getStyle('B5')->getFont()->setName('Arial');
        $sheet->getStyle('B5')->getFont()->setSize(9);
        $sheet->setCellValue('B5', 'Поставщик:');

        $sheet->mergeCells("G5:AG5");
        $sheet->getStyle('G5')->getFont()->setName('Arial');
        $sheet->getStyle('G5')->getFont()->setSize(9);
        $sheet->getStyle('G5')->getFont()->setBold(true);
        #$sheet->setCellValue('G5', 'ООО "АГРО-ПАРТНЕР СТАРОБЕШЕВО"');
        $sheet->setCellValue('G5', sprintf("%s",  $products[0]->provider->title));

        $sheet->mergeCells("G6:AG6");
        $sheet->getStyle('G6')->getFont()->setName('Arial');
        $sheet->getStyle('G6')->getFont()->setSize(9);
        $sheet->getRowDimension("6")->setRowHeight(25);
        #$sheet->setCellValue('G6', "Тел.: 050132-57-97, \r\n код по ЕГРПОУ 33050430, ИНН 33050430, № свид. 07104934");
        $sheet->setCellValue('G6', sprintf("Тел.: %s, \r\nкод по %s, ИНН %s, № свид. %s", $products[0]->provider->phone, $products[0]->provider->code, $products[0]->provider->inn, $products[0]->provider->certificateNumber ));
        $sheet->getStyle("G6")->getAlignment()->setWrapText(true);

        $sheet->mergeCells("B8:F8");
        $sheet->getStyle('B8')->getFont()->setName('Arial');
        $sheet->getStyle('B8')->getFont()->setSize(9);
        $sheet->setCellValue('B8', 'Покупатель:');

        $sheet->mergeCells("G8:AG8");
        $sheet->getStyle('G8')->getFont()->setName('Arial');
        $sheet->getStyle('G8')->getFont()->setSize(9);
        $sheet->getStyle('G8')->getFont()->setBold(true);
        $sheet->setCellValue('G8', 'МАЛОЕ ЧАСТНОЕ ПРЕДПРИЯТИЕ  "АГРО- СЕРВИС БЕШЕВСКИЙ"');
        #$sheet->setCellValue('G8', sprintf("%s",  ));

        $sheet->mergeCells("G9:AG9");
        $sheet->getStyle('G9')->getFont()->setName('Arial');
        $sheet->getStyle('G9')->getFont()->setSize(9);
        $sheet->getRowDimension("9")->setRowHeight(35);
        $sheet->setCellValue('G9', "Т/с 40702810520000001380, в банке ЦРБ ДНР, МФО 310101001,\nДНР, 87253,Старобешевский р-н, с.Новозарьевка, ул. Мариупольская, д.16, тел.: 0623452850,\nкод по ЕГРПОУ 24452959");
        #$sheet->setCellValue('G9', sprintf("Т/с $s, в банке ЦРБ ДНР, МФО $s,\n$s, тел.: $s,\nкод по $s",  ));
        $sheet->getStyle("G9")->getAlignment()->setWrapText(true);

        $sheet->mergeCells("B11:F11");
        $sheet->getStyle('B11')->getFont()->setName('Arial');
        $sheet->getStyle('B11')->getFont()->setSize(10);
        $sheet->setCellValue('B11', 'Договор:');

        $sheet->mergeCells("G11:AG11");
        $sheet->getStyle('G11')->getFont()->setName('Arial');
        $sheet->getStyle('G11')->getFont()->setSize(10);
        #$sheet->setCellValue('G11', 'Договор поставки (руб)');
        $sheet->setCellValue('G11', sprintf("%s",  $products[0]->contractTitle));

        $sheet->mergeCells("B13:F13");
        $sheet->getStyle('B13')->getFont()->setName('Arial');
        $sheet->getStyle('B13')->getFont()->setSize(10);
        $sheet->setCellValue('B13', 'Склад:');

        $sheet->mergeCells("G13:AG13");
        $sheet->getStyle('G13')->getFont()->setName('Arial');
        $sheet->getStyle('G13')->getFont()->setSize(10);
        #$sheet->setCellValue('G13', 'Склад запчастей');
        $sheet->setCellValue('G13', sprintf("%s",  $products[0]->warehouseTitle));

        $sheet->mergeCells("B15:C16");
        $sheet->getStyle('B15')->getFont()->setName('Arial');
        $sheet->getStyle('B15')->getFont()->setSize(9);
        $sheet->getStyle('B15')->getFont()->setBold(true);
        $sheet->getStyle("B15")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("B15")->getAlignment()->setVertical('center');
        $sheet->setCellValue('B15', '№');

        $sheet->mergeCells("D15:T16");
        $sheet->getStyle('D15')->getFont()->setName('Arial');
        $sheet->getStyle('D15')->getFont()->setSize(9);
        $sheet->getStyle('D15')->getFont()->setBold(true);
        $sheet->getStyle("D15")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("D15")->getAlignment()->setVertical('center');
        $sheet->setCellValue('D15', 'Товар');

        $sheet->mergeCells("U15:W16");
        $sheet->getStyle('U15')->getFont()->setName('Arial');
        $sheet->getStyle('U15')->getFont()->setSize(9);
        $sheet->getStyle('U15')->getFont()->setBold(true);
        $sheet->getStyle("U15")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("U15")->getAlignment()->setVertical('center');
        $sheet->setCellValue('U15', 'Кол-во');

        $sheet->mergeCells("X15:Y16");
        $sheet->getStyle('X15')->getFont()->setName('Arial');
        $sheet->getStyle('X15')->getFont()->setSize(9);
        $sheet->getStyle('X15')->getFont()->setBold(true);
        $sheet->getStyle("X15")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("X15")->getAlignment()->setVertical('center');
        $sheet->setCellValue('X15', 'Ед.');
        
        $sheet->mergeCells("Z15:AC16");
        $sheet->getStyle('Z15')->getFont()->setName('Arial');
        $sheet->getStyle('Z15')->getFont()->setSize(9);
        $sheet->getStyle('Z15')->getFont()->setBold(true);
        $sheet->getStyle("Z15")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("Z15")->getAlignment()->setVertical('center');
        $sheet->setCellValue('Z15', 'Цена');

        $sheet->mergeCells("AD15:AG16");
        $sheet->getStyle('AD15')->getFont()->setName('Arial');
        $sheet->getStyle('AD15')->getFont()->setSize(9);
        $sheet->getStyle('AD15')->getFont()->setBold(true);
        $sheet->getStyle("AD15")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("AD15")->getAlignment()->setVertical('center');
        $sheet->setCellValue('AD15', 'Сумма');

        
        $qty = 0;
        $sum = 0;
        foreach($products as $product){
            $sheet->mergeCells(sprintf("B%d:C%d",$qty+17,$qty+17));
            $sheet->getStyle(sprintf("B%d",$qty+17))->getFont()->setName('Arial');
            $sheet->getStyle(sprintf("B%d",$qty+17))->getFont()->setSize(8);
            $sheet->setCellValue(sprintf("B%d",$qty+17), $qty+1);
            $sheet->mergeCells(sprintf("D%d:T%d",$qty+17,$qty+17));
            $sheet->getStyle(sprintf("D%d",$qty+17))->getFont()->setName('Arial');
            $sheet->getStyle(sprintf("D%d",$qty+17))->getFont()->setSize(8);
            $sheet->setCellValue(sprintf("D%s",$qty+17), $product->title);
            $sheet->mergeCells(sprintf("U%d:W%d",$qty+17,$qty+17));
            $sheet->getStyle(sprintf("U%d",$qty+17))->getFont()->setName('Arial');
            $sheet->getStyle(sprintf("U%d",$qty+17))->getFont()->setSize(8);
            $sheet->setCellValue(sprintf("U%d",$qty+17), $product->qty);
            $sheet->mergeCells(sprintf("X%d:Y%d",$qty+17,$qty+17));
            $sheet->getStyle(sprintf("X%d",$qty+17))->getFont()->setName('Arial');
            $sheet->getStyle(sprintf("X%d",$qty+17))->getFont()->setSize(8);
            $sheet->setCellValue(sprintf("X%s",$qty+17), $product->unit);
            $sheet->getStyle(sprintf("X%d",$qty+17))->getAlignment()->setHorizontal('left');
            $sheet->mergeCells(sprintf("Z%d:AC%d",$qty+17,$qty+17));
            $sheet->getStyle(sprintf("Z%d",$qty+17))->getFont()->setName('Arial');
            $sheet->getStyle(sprintf("Z%d",$qty+17))->getFont()->setSize(8);
            $sheet->setCellValue(sprintf("Z%d",$qty+17), $product->price);
            $sheet->mergeCells(sprintf("AD%d:AG%d",$qty+17,$qty+17));
            $sheet->getStyle(sprintf("AD%d",$qty+17))->getFont()->setName('Arial');
            $sheet->getStyle(sprintf("AD%d",$qty+17))->getFont()->setSize(8);
            $sheet->setCellValue(sprintf("AD%d",$qty+17), $product->price*$product->qty);
            $sum += $product->price*$product->qty;
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
        $sheet->getStyle(sprintf("B15:AG%d",$qty+16))->applyFromArray($border);
        $spreadsheet->getActiveSheet()->getStyle('B15:AG16')
    ->getFill()->getStartColor()->setARGB('FFFF0000');

        $sheet->mergeCells(sprintf("AA%d:AC%d",$qty+18,$qty+18));
        $sheet->getStyle(sprintf("AA%d",$qty+18))->getFont()->setName('Arial');
        $sheet->getStyle(sprintf("AA%d",$qty+18))->getFont()->setSize(9);
        $sheet->getStyle(sprintf("AA%d",$qty+18))->getFont()->setBold(true);
        $sheet->setCellValue(sprintf("AA%d",$qty+18), "Итого:");

        $sheet->mergeCells(sprintf("AD%d:AG%d",$qty+18,$qty+18));
        $sheet->getStyle(sprintf("AD%d",$qty+18))->getFont()->setName('Arial');
        $sheet->getStyle(sprintf("AD%d",$qty+18))->getFont()->setSize(9);
        $sheet->getStyle(sprintf("AD%d",$qty+18))->getFont()->setBold(true);
        $sheet->setCellValue(sprintf("AD%d",$qty+18), $sum);

        $sheet->mergeCells(sprintf("B%d:AG%d",$qty+20,$qty+20));
        $sheet->getStyle(sprintf("B%d",$qty+20))->getFont()->setName('Arial');
        $sheet->getStyle(sprintf("B%d",$qty+20))->getFont()->setSize(9);
        $sheet->setCellValue(sprintf("B%d",$qty+20), sprintf("Всего наименований %d на сумму %d руб.",$qty, $sum));

        $sheet->mergeCells(sprintf("B%d:AF%d",$qty+21,$qty+21));
        $sheet->getStyle(sprintf("B%d",$qty+21))->getFont()->setName('Arial');
        $sheet->getStyle(sprintf("B%d",$qty+21))->getFont()->setSize(9);
        $sheet->getStyle(sprintf("B%d",$qty+21))->getFont()->setBold(true);
        $sheet->setCellValue(sprintf("B%d",$qty+21),  $sum);
        $sheet->getStyle(sprintf("B%d",$qty+21))->getAlignment()->setHorizontal('left');

        $sheet->mergeCells(sprintf("B%d:AG%d",$qty+22,$qty+22));
        $sheet->getStyle(sprintf("B%d:AG%d",$qty+22,$qty+22))->getBorders()->getBottom()->setBorderStyle('thick');

        $sheet->mergeCells(sprintf("B%d:G%d",$qty+24,$qty+24));
        $sheet->getStyle(sprintf("B%d",$qty+24))->getFont()->setName('Arial');
        $sheet->getStyle(sprintf("B%d",$qty+24))->getFont()->setSize(9);
        $sheet->getStyle(sprintf("B%d",$qty+24))->getFont()->setBold(true);
        $sheet->setCellValue(sprintf("B%d",$qty+24),  "Отгрузил(а):");

        $sheet->mergeCells(sprintf("H%d:P%d",$qty+24,$qty+24));
        $sheet->getStyle(sprintf("H%d:P%d",$qty+24,$qty+24))->getBorders()->getBottom()->setBorderStyle('thick');

        $sheet->mergeCells(sprintf("R%d:V%d",$qty+24,$qty+24));
        $sheet->getStyle(sprintf("R%d",$qty+24))->getFont()->setName('Arial');
        $sheet->getStyle(sprintf("R%d",$qty+24))->getFont()->setSize(9);
        $sheet->getStyle(sprintf("R%d",$qty+24))->getFont()->setBold(true);
        $sheet->setCellValue(sprintf("R%d",$qty+24),  "Получил(а):");

        $sheet->mergeCells(sprintf("W%d:AG%d",$qty+24,$qty+24));
        $sheet->getStyle(sprintf("W%d:AG%d",$qty+24,$qty+24))->getBorders()->getBottom()->setBorderStyle('thick');

        $writer = new Xlsx($spreadsheet);
        $writer->save('products.xlsx');
    }
}

