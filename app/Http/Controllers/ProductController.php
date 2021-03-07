<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Product;
use App\Log;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::with('user', 'provider')->latest()->get();
        for($i = 0; $i < count($products); $i++){
            $products[$i]->parseDate = strftime("%Y-%m-%d",  $products[$i]->date);
        }

        return response()->json($products);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function contractIndex(Request $request)
    {
        $contracts = Product::with('provider')
        ->select('contractTitle', 'date', 'providerId')
        ->latest()
        ->get()
        ->unique('contractTitle');

        return response()->json($contracts);
    }

    public function getWaybills(Request $request){
        $waybills = Product::select('waybillTitle')
        ->latest()
        ->get()
        ->unique('waybillTitle');

        return response()->json($waybills);
    }

    public function getWarehouses(Request $request){
        $warehouses = Product::select('warehouseTitle')
        ->latest()
        ->get()
        ->unique('warehouseTitle');

        return response()->json($warehouses);
    }

    public function getProductsByCompany(Request $request){

        $products = Product::with('user', 'provider')->latest()->get();
        for($i = 0; $i < count($products); $i++){
            $products[$i]->parseDate = strftime("%Y-%m-%d",  $products[$i]->date);
        }
        if($request->user()->company == 'Нейтральная'){
            return response()->json($products);
        }
        $i = 0;
        foreach($products as $product){
            if($product->user->company != $request->user()->company){
                unset($products[$i]);
            }
            $i++;
        }
        return response()->json($products);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('product.create');
    }

    /**
     * @param \App\Http\Requests\ProductStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        $request->validated();
        $product = new Product;
        $product->title = $request->input('title');
        $product->price = $request->input('price');
        $product->qty = $request->input('qty');
        $product->unit = $request->input('unit');
        $product->waybillTitle = $request->input('waybillTitle');
        $product->contractTitle = $request->input('contractTitle');
        $product->date = $request->input('date'); 
        $product->warehouseTitle = $request->input('warehouseTitle');
        $product->vendorCode = $request->input('vendorCode');
        if($request->input('usedQty') != null){
            $product->usedQty = $request->input('usedQty');
        }
        else{
            $product->usedQty = 0;
        }
        $product->writtenOffQty = $request->input('writtenOffQty');
        $product->providerId = (\App\Provider::firstOrCreate(['title' => $request->input('providerId')]))->id;
        $product->snippedUserId = \Auth::user()->id;
        $product->save();
        Log::create([
            'userId' => \Auth::user()->id,
            'oldValue' => sprintf("Создан продукт: %s", $product->title),
            'newValue' => "",
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Product $product)
    {
        return view('product.show', compact('product'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Product $product)
    {
        return view('product.edit', compact('product'));
    }

    /**
     * @param \App\Http\Requests\ProductUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        $request->validated();
        $product = Product::find($id);
        $product->title = $request->input('title');
        $product->price = $request->input('price');
        $product->qty = $request->input('qty');
        $product->unit = $request->input('unit');
        $product->waybillTitle = $request->input('waybillTitle');
        $product->contractTitle = $request->input('contractTitle');
        $product->date = $request->input('date'); 
        $product->warehouseTitle = $request->input('warehouseTitle');
        $product->vendorCode = $request->input('vendorCode');
        if($request->input('usedQty') != null){
            $product->usedQty = $request->input('usedQty');
        }
        else{
            $product->usedQty = 0;
        }
        $product->writtenOffQty = $request->input('writtenOffQty');
        $product->providerId = (\App\Provider::firstOrCreate(['title' => $request->input('providerId')]))->id;
        $product->snippedUserId = $request->input('snippedUserId');
        $product->save();
        Log::create([
            'userId' => \Auth::user()->id,
            'oldValue' => sprintf("Изменен продукт с id: %d", $product->id),
            'newValue' => "",
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $product = Product::find($id);
        $product->delete();
        Log::create([
            'userId' => \Auth::user()->id,
            'oldValue' => sprintf("Удален продукт с id: %d", $id),
            'newValue' => "",
        ]);
    }
}
