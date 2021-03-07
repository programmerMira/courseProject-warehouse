<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransportTypeStoreRequest;
use App\Http\Requests\TransportTypeUpdateRequest;
use App\TransportType;
use Illuminate\Http\Request;

class TransportTypeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transportTypes = TransportType::all();

        return response()->json($transportTypes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('transportType.create');
    }

    /**
     * @param \App\Http\Requests\TransportTypeStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransportTypeStoreRequest $request)
    {
        $request->validated();
        $transportType = new TransportType;
        $transportType->title = $request->input('title');
        $transportType->save();
        \App\Log::create([
            'userId' => \Auth::user()->id,
            'oldValue' => sprintf("Создан тип транспорта: %s", $transportType->title),
            'newValue' => "",
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\TransportType $transportType
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, TransportType $transportType)
    {
        return view('transportType.show', compact('transportType'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\TransportType $transportType
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, TransportType $transportType)
    {
        return view('transportType.edit', compact('transportType'));
    }

    /**
     * @param \App\Http\Requests\TransportTypeUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(TransportTypeUpdateRequest $request, $id)
    {
        $request->validated();
        $transportType = TransportType::find($id);
        $transportType->title = $request->input('title');
        $transportType->save();
        \App\Log::create([
            'userId' => \Auth::user()->id,
            'oldValue' => sprintf("Изменен тип транспорта с id: %d", $transportType->id),
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
        $transportType = TransportType::find($id);
        $transportType->delete();
        \App\Log::create([
            'userId' => \Auth::user()->id,
            'oldValue' => sprintf("Удален тип транспорта с id: %d", $id),
            'newValue' => "",
        ]);
    }
}
