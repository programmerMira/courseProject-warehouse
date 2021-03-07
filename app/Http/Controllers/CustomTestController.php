<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Services\ProductImporter;
use App\Services\ProductExporter;


class CustomTestController extends Controller
{
    public function index(){
        //default function
    }
    public function upload_file(Request $request): \Illuminate\Http\RedirectResponse
    {
        $importer = new ProductImporter;
        #dd($request->file,
        #    $request->doc_type
        #);
        $importer->import($request);
        return redirect()->route('incomes');
    }
    public function generate_file(Request $reques)
    {
        /*dd($reques->doc_type, //тут тип документа (income or detailCard)
           $reques->doc_name_contract, // название накладной, если не выбрано, то null
           $reques->doc_name_detail); // название детали, если не выбрано, то null*/
        if($reques->doc_type == "income"){
            if($reques->doc_name_contract != null){
                $exporter = new ProductExporter;
                $exporter->export(\App\Product::with('provider')->where('waybillTitle', $reques->doc_name_contract)->get());
                return response()->download(public_path('products.xlsx'));
            }
        }
        else{
            if($reques->doc_name_detail != null){
                $exporter = new ProductExporter;
                $exporter->exportCard(\App\Product::with('provider')->where('waybillTitle', $reques->doc_name_contract)->get());
                return response()->download(public_path('products.xlsx'));
            }
        }
        return redirect()->route('incomes');
    }
    public function testAxiosHistory(){
        $test_arr = [
            [
                "change_type"=>'Изменено',
                "change_date"=>'2020-12-12',
                "change_user"=> 'User1',
                "change_initial"=> 'Что-то добавлено, что-то удалено',
                "change_became"=> 'Что-то дообавлено, ',
            ],
            [
                "change_type"=>'Добавлено',
                "change_date"=> '2020-12-13',
                "change_user"=> 'User1',
                "change_initial"=> 'Что-то добавлено, что-то удалено',
                "change_became"=> 'Что-то дообавлено, удалено',
            ],
            [
                "change_type"=>'Удалено',
                "change_date"=> '2020-11-13',
                "change_user"=> 'User1',
                "change_initial"=> 'Что-то добавлено, что-то удалено',
                "change_became"=> 'Что-то дообавлено, удалено',
            ]
        ];

        return response()->json($test_arr);
    }
}
