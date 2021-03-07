<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProviderStoreRequest;
use App\Http\Requests\ProviderUpdateRequest;
use App\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $providers = Provider::latest()->get();

        return response()->json($providers);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('provider.create');
    }

    /**
     * @param \App\Http\Requests\ProviderStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProviderStoreRequest $request)
    {
        $request->validated();
        $provider = new Provider;
        $provider->title = $request->input('title');
        $provider->phone = $request->input('phone');
        $provider->code = $request->input('code');
        $provider->inn = $request->input('inn');
        $provider->certificateNumber = $request->input('certificateNumber');
        $provider->adress = $request->input('adress');
        $provider->save();
        \App\Log::create([
            'userId' => \Auth::user()->id,
            'oldValue' => sprintf("Создан поставщик: %s", $provider->title),
            'newValue' => "",
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Provider $provider
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Provider $provider)
    {
        return view('provider.show', compact('provider'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Provider $provider
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Provider $provider)
    {
        return view('provider.edit', compact('provider'));
    }

    /**
     * @param \App\Http\Requests\ProviderUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProviderUpdateRequest $request, $id)
    {
        $request->validated();
        $provider = Provider::find($id);
        $provider->title = $request->input('title');
        $provider->phone = $request->input('phone');
        $provider->code = $request->input('code');
        $provider->inn = $request->input('inn');
        $provider->certificateNumber = $request->input('certificateNumber');
        $provider->adress = $request->input('adress');
        $provider->save();
        \App\Log::create([
            'userId' => \Auth::user()->id,
            'oldValue' => sprintf("Изменен поставщик с id: %d", $provider->id),
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
        $provider = Provider::find($id);
        $provider->delete();
        \App\Log::create([
            'userId' => \Auth::user()->id,
            'oldValue' => sprintf("Удален поставщик с id: %d", $id),
            'newValue' => "",
        ]);
    }
}
