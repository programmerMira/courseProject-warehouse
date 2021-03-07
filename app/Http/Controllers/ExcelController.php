<?php

namespace App\Http\Controllers;

#use App\Http\Requests\ProductStoreRequest;
#use App\Http\Requests\ProductUpdateRequest;
use App\Product;
use Illuminate\Http\Request;
use App\Services\ProductExporter;
use App\Services\DetailCardExporter;
use App\Services\ProductImporter;

class ExcelController extends Controller
{
    public function export(Request $request)
    {
        if($request->doc_type == "income"){
            if($request->doc_name_contract != null){
                $exporter = new ProductExporter;
                $exporter->export(\App\Product::with('provider')->where('waybillTitle', $request->doc_name_contract)->get());
                \App\Log::create([
                    'userId' => \Auth::user()->id,
                    'oldValue' => sprintf("Выгрузил накладную под названием: %s", $request->doc_name_contract),
                    'newValue' => "",
                ]);
                return response()->download(public_path('products.xlsx'));
            }
        }
        else{
            if($request->doc_name_transport != null){
                $exporter = new DetailCardExporter;
                $detailsCards = \App\DetailsCard::with('product', 'transport')->where([
                    ['created_at', '>', $request->doc_name_start_date],
                    ['created_at', '<', $request->doc_name_end_date]])->get();
                $i = 0;
                foreach($detailsCards as $detailsCard){
                    if($detailsCard->transport->title != $request->doc_name_transport){
                        unset($detailsCards[$i]);
                    }
                    $i++;
                }
                if(count($detailsCards) != 0){
                    $exporter->export($detailsCards,$request->doc_name_start_date, $request->doc_name_end_date, $request->doc_name_transport);
                    return response()->download(public_path('card.xlsx'));
                }
            }
        }
        return redirect()->route('incomes');
    }


    public function import(Request $request)
    {
        $importer = new ProductImporter;
        $importer->import($request);
        return redirect()->route('incomes');
    }
}
