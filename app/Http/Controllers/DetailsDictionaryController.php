<?php

namespace App\Http\Controllers;

use App\DetailsDictionary;
use App\Http\Requests\DetailsDictionaryStoreRequest;
use App\Http\Requests\DetailsDictionaryUpdateRequest;
use Illuminate\Http\Request;

class DetailsDictionaryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $detailsDictionaries = DetailsDictionary::with('product', 'transport')->latest()->get();

        return response()->json($detailsDictionaries);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('detailsDictionary.create');
    }

    /**
     * @param \App\Http\Requests\DetailsDictionaryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DetailsDictionaryStoreRequest $request)
    {
        $request->validated();
        $detailsDictionary = new DetailsDictionary;
        $detailsDictionary->qty = $request->input('qty');
        $detailsDictionary->unit = $request->input('unit');
        $detailsDictionary->transportId = (\App\Transport::firstOrCreate(['title' => $request->input('transportId')]))->id;
        $detailsDictionary->productId = (\App\Product::firstOrCreate(['title' => $request->input('productId')]))->id;
        $detailsDictionary->save();
        \App\Log::create([
            'userId' => \Auth::user()->id,
            'oldValue' => "Создан словарь деталей",
            'newValue' => "",
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\DetailsDictionary $detailsDictionary
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DetailsDictionary $detailsDictionary)
    {
        return view('detailsDictionary.show', compact('detailsDictionary'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\DetailsDictionary $detailsDictionary
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, DetailsDictionary $detailsDictionary)
    {
        return view('detailsDictionary.edit', compact('detailsDictionary'));
    }

    /**
     * @param \App\Http\Requests\DetailsDictionaryUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(DetailsDictionaryUpdateRequest $request, $id)
    {
        $request->validated();
        $detailsDictionary = DetailsDictionary::find($id);
        $detailsDictionary->qty = $request->input('qty');
        $detailsDictionary->unit = $request->input('unit');
        $detailsDictionary->transportId = (\App\Transport::firstOrCreate(['title' => $request->input('transportId')]))->id;
        $detailsDictionary->productId = (\App\Product::firstOrCreate(['title' => $request->input('productId')]))->id;
        $detailsDictionary->save();
        \App\Log::create([
            'userId' => \Auth::user()->id,
            'oldValue' => sprintf("Изменен словарь с id: %d", $detailsDictionary->id),
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
        $detailsDictionary = DetailsDictionary::find($id);
        $detailsDictionary->delete();
        \App\Log::create([
            'userId' => \Auth::user()->id,
            'oldValue' => sprintf("Удален словарь деталей с id: %d", $id),
            'newValue' => "",
        ]);
    }
}
