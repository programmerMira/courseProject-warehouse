<?php

namespace App\Http\Controllers;

use App\DetailsCard;
use App\Http\Requests\DetailsCardStoreRequest;
use App\Http\Requests\DetailsCardUpdateRequest;
use Illuminate\Http\Request;

class DetailsCardController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $detailsCards = DetailsCard::with('product', 'transport')->latest()->get();
        for($i = 0; $i < count($detailsCards); $i++){
            $detailsCards[$i]->parseDate = strftime("%Y-%m-%d",  $detailsCards[$i]->date);
        }
        return response()->json($detailsCards);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Transport->Title
     * @return \Illuminate\Http\Response
     */
    public function getDetailCardsByTransport(Request $request, $transport)
    {
        $detailsCards = DetailsCard::with('product', 'transport')->latest()->get();
        for($i = 0; $i < count($detailsCards); $i++){
            $detailsCards[$i]->parseDate = strftime("%Y-%m-%d",  $detailsCards[$i]->date);
        }
        $i = 0;
        foreach($detailsCards as $detailsCard){
            if($detailsCard->transport->title != $transport){
                unset($detailsCards[$i]);
            }
            $i++;
        }
        return response()->json($detailsCards);
    }

    public function getDetailCardsByCompany(Request $request){

        $detailsCards = DetailsCard::with('product', 'transport')->latest()->get();
        for($i = 0; $i < count($detailsCards); $i++){
            $detailsCards[$i]->parseDate = strftime("%Y-%m-%d",  $detailsCards[$i]->date);
        }
        if($request->user()->company == 'Нейтральная'){
            return response()->json($detailsCards);
        }
        $i = 0;
        foreach($detailsCards as $detailsCard){
            if($detailsCard->product->user->company != $request->user()->company){
                unset($detailsCards[$i]);
            }
            $i++;
        }
        return response()->json($detailsCards);
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('detailsCard.create');
    }

    /**
     * @param \App\Http\Requests\DetailsCardStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DetailsCardStoreRequest $request)
    {
        $request->validated();
        $detailsCard = new DetailsCard;
        $detailsCard->date = $request->input('date');
        $detailsCard->document = $request->input('document');
        $detailsCard->qty = $request->input('qty');
        $detailsCard->unit = $request->input('unit');
        $product = \App\Product::firstOrCreate(['title' => $request->input('productId')]);
        $sum = DetailsCard::where('productId', $product->id)->sum('qty');
        if($detailsCard->qty > $product->qty - $sum){
            abort(500, 'Written off more than delivered.'); 
        }
        $detailsCard->productId = ($product)->id;
        $detailsCard->transportId = (\App\Transport::firstOrCreate(['title' => $request->input('transportId')]))->id;
        $detailsCard->save();
        \App\Log::create([
            'userId' => \Auth::user()->id,
            'oldValue' => "Создана карточка детали",
            'newValue' => "",
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\DetailsCard $detailsCard
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DetailsCard $detailsCard)
    {
        return view('detailsCard.show', compact('detailsCard'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\DetailsCard $detailsCard
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, DetailsCard $detailsCard)
    {
        return view('detailsCard.edit', compact('detailsCard'));
    }

    /**
     * @param \App\Http\Requests\DetailsCardUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(DetailsCardUpdateRequest $request, $id)
    {
        $request->validated();
        $detailsCard = DetailsCard::find($id);
        $detailsCard->date = $request->input('date');
        $detailsCard->document = $request->input('document');
        $detailsCard->qty = $request->input('qty');
        $detailsCard->unit = $request->input('unit');
        $product = \App\Product::firstOrCreate(['title' => $request->input('productId')]);
        $sum = DetailsCard::where('productId', $product->id)->sum('qty');
        if($detailsCard->qty > $product->qty - $sum){
            abort(500, 'Written off more than delivered.'); 
        }
        $detailsCard->productId = ($product)->id;
        $detailsCard->transportId = (\App\Transport::firstOrCreate(['title' => $request->input('transportId')]))->id;
        $detailsCard->save();
        \App\Log::create([
            'userId' => \Auth::user()->id,
            'oldValue' => sprintf("Изменена карточка детали с id: %d", $detailsCard->id),
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

        $detailsCard = DetailsCard::find($id);
        $detailsCard->delete();
        \App\Log::create([
            'userId' => \Auth::user()->id,
            'oldValue' => sprintf("Удалена карточка детали с id: %d", $id),
            'newValue' => "",
        ]);
    }
}
