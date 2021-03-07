<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransportStoreRequest;
use App\Http\Requests\TransportUpdateRequest;
use App\Transport;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transports = Transport::with('transport_type')->latest()->get();
        for($i = 0; $i < count($transports); $i++){
            $transports[$i]->parseCreationDate = strftime("%Y-%m-%d",  $transports[$i]->creationDate);
            $transports[$i]->parseCommissioningDate = strftime("%Y-%m-%d",  $transports[$i]->commissioningDate);
            $transports[$i]->parseDetailsUpdateDate = strftime("%Y-%m-%d",  $transports[$i]->detailsUpdateDate);
        }

        return response()->json($transports);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('transport.create');
    }

    /**
     * @param \App\Http\Requests\TransportStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransportStoreRequest $request)
    {
        $request->validated();
        $transport = new Transport;
        $transport->title = $request->input('title');
        $transport->creationDate = $request->input('creationDate');
        $transport->commissioningDate = $request->input('commissioningDate');
        $transport->detailsUpdateDate = $request->input('detailsUpdateDate');
        $transport->number = $request->input('number');
        $transport->brand = $request->input('brand');
        $transport->model = $request->input('model');
        $transport->chassis_engine_number = $request->input('chassis_engine_number');
        $transport->engine_volume = $request->input('engine_volume');
        $transport->weight = $request->input('weight');
        $transport->color = $request->input('color');
        $transport->certificate = $request->input('certificate');
        $transport->factory_number = $request->input('factory_number');
        $transport->rent = $request->input('rent');
        $transport->typeId = (\App\TransportType::firstOrCreate(['title' => $request->input('typeId')]))->id;
        $transport->save();
        \App\Log::create([
            'userId' => \Auth::user()->id,
            'oldValue' => sprintf("Создан транспорт: %s", $transport->title),
            'newValue' => "",
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Transport $transport
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Transport $transport)
    {
        return view('transport.show', compact('transport'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Transport $transport
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Transport $transport)
    {
        return view('transport.edit', compact('transport'));
    }

    /**
     * @param \App\Http\Requests\TransportUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(TransportUpdateRequest $request, $id)
    {
        $request->validated();
        $transport = Transport::find($id);
        $transport->title = $request->input('title');
        $transport->creationDate = $request->input('creationDate');
        $transport->commissioningDate = $request->input('commissioningDate');
        $transport->detailsUpdateDate = $request->input('detailsUpdateDate');
        $transport->number = $request->input('number');
        $transport->brand = $request->input('brand');
        $transport->model = $request->input('model');
        $transport->chassis_engine_number = $request->input('chassis_engine_number');
        $transport->engine_volume = $request->input('engine_volume');
        $transport->weight = $request->input('weight');
        $transport->color = $request->input('color');
        $transport->certificate = $request->input('certificate');
        $transport->factory_number = $request->input('factory_number');
        $transport->rent = $request->input('rent');
        $transport->typeId = (\App\TransportType::firstOrCreate(['title' => $request->input('typeId')]))->id;
        $transport->save();
        \App\Log::create([
            'userId' => \Auth::user()->id,
            'oldValue' => sprintf("Изменен транспорт с id: %d", $transport->id),
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
        $transport = Transport::find($id);
        $transport->delete();
        \App\Log::create([
            'userId' => \Auth::user()->id,
            'oldValue' => sprintf("Удален транспорт с id: %d", $id),
            'newValue' => "",
        ]);
    }
}
