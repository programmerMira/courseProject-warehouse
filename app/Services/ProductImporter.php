<?php

namespace App\Services;

use App\Product;
use App\Waybill;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Http\Request;


class ProductImporter
{
    public function import(Request $request){
        $file = $request->file('file');
        $xls = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->path());
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();

        # чтение номера накладной

        $value = $sheet->getCell("B3")->getValue();
        $startIndex = mb_strpos($value, '№');
        $endIndex = mb_strpos($value, 'от');
        if ($startIndex==false || $endIndex==false) {
            throw new Exception('Неправильный формат. Ошибка в названии накладной');
        }
        $waybillNumber = mb_substr($value, $startIndex+1, $endIndex-$startIndex-1);
        $waybillNumber = trim($waybillNumber);

        #дата накладной

        $waybillDate = mb_substr($value, $endIndex+2);
        $waybillDate = trim($waybillDate);
        $waybillDate = str_replace("г.", "", $waybillDate);
        $tmp = date_parse_from_format("j M Y", $waybillDate);
        $day = $tmp['day'];
        $year = $tmp['year'];
        $month = trim(str_replace($day, "", str_replace($year, "", $waybillDate)));
        if($month=="января"){
            $month = "01";
        }
        else if($month=="февраля"){
            $month = "02";
        }
        else if($month=="марта"){
            $month = "03";
        }
        else if($month=="апреля"){
            $month = "04";
        }
        else if($month=="мая"){
            $month = "05";
        }
        else if($month=="июня"){
            $month = "06";
        }
        else if($month=="июля"){
            $month = "07";
        }
        else if($month=="августа"){
            $month = "08";
        }
        else if($month=="сентября"){
            $month = "09";
        }
        else if($month=="октября"){
            $month = "10";
        }
        else if($month=="ноября"){
            $month = "11";
        }
        else if($month=="декабря"){
            $month = "12";
        }
        else{
            throw new Exception('Неправильный формат. Ошибка в дате накладной');
        }
        $waybillDate = sprintf("%d-%d-%d",$year,$month,$day);

        #данные продавца

        $providerTitle = $sheet->getCell("G5")->getValue();
        $value = $sheet->getCell("G6")->getValue();
        $value = trim($value);
        $startIndex = mb_strpos($value, ':');
        $endIndex = mb_strpos($value, 'код');
        if ($startIndex==false || $endIndex==false) {
            throw new Exception('Неправильный формат. Ошибка в номере продавца');
        }
        $providerNumber = mb_substr($value, $startIndex+1, $endIndex-$startIndex-3);
        $providerNumber = trim($providerNumber);
        $startIndex = mb_strpos($value, 'код по');
        $endIndex = mb_strpos($value, 'ИНН');
        if ($startIndex==false || $endIndex==false) {
            throw new Exception('Неправильный формат. Ошибка в коде продавца');
        }
        $providerCode = mb_substr($value, $startIndex+6, $endIndex-$startIndex-8);
        $providerCode = trim($providerCode);
        $startIndex = mb_strpos($value, 'ИНН');
        $endIndex = mb_strpos($value, '№ свид');
        if ($startIndex==false || $endIndex==false) {
            throw new Exception('Неправильный формат. Ошибка в идентификационном номере продавца');
        }
        $providerInn = mb_substr($value, $startIndex+3, $endIndex-$startIndex-3);
        $providerInn = trim($providerInn);
        $providerInn = str_replace(",", "", $providerInn);
        $startIndex = mb_strpos($value, '№ свид');
        $endIndex = strlen($value);
        if ($startIndex==false || $endIndex==false) {
            throw new Exception('Неправильный формат. Ошибка в номере свидетельства продавца');
        }
        $providerCerificate = mb_substr($value, $startIndex+7, $endIndex-$startIndex-1);
        $providerCerificate = trim($providerCerificate);
        $providerCerificate = str_replace(",", "", $providerCerificate);
        $provider = \App\Provider::firstOrCreate([
            'title' => $providerTitle,
            'phone' => $providerNumber,
            'code' => $providerCode,
            'inn' => $providerInn,
            'certificateNumber' => $providerCerificate,
            'adress' => ""
        ]);

        #договор

        $contractType = $sheet->getCell("G11")->getValue();
        $value = $sheet->getCell("B17")->getValue();
        $i = 17;
        while($value != ""){
            $i++;
            $value = $sheet->getCell(sprintf("B%d",$i))->getValue();
        }
        $i--;
        $contractProductsQty = $sheet->getCell(sprintf("B%d",$i))->getValue();
        $i += 2;
        $contractProductsPriceSumm = $sheet->getCell(sprintf("AD%d",$i))->getValue();

        #склад

        $warehouseTitle = $sheet->getCell("G13")->getValue();

        # чтение товаров
        
        for($j = 17; $j<$contractProductsQty + 17; $j++){
            $product = \App\Product::firstOrCreate([
                'title' => $sheet->getCell(sprintf("D%d",$j))->getValue(),
                'price' => $sheet->getCell(sprintf("Z%d",$j))->getValue(),
                'qty' => $sheet->getCell(sprintf("U%d",$j))->getValue(),
                'unit' => $sheet->getCell(sprintf("X%d",$j))->getValue(),
                'providerId' => $provider->id,
                'waybillTitle' => $waybillNumber,
                'contractTitle' => $contractType,
                'date' => $waybillDate,
                'warehouseTitle' =>  $warehouseTitle,
                'vendorCode' => "",
                'usedQty' => 0,
                'writtenOffQty' => 0,
                'snippedUserId' => \Auth::user()->id,
            ]);
        }
        \App\Log::create([
            'userId' => \Auth::user()->id,
            'oldValue' => "Загрузил накладную",
            'newValue' => "",
        ]);
    }
}

