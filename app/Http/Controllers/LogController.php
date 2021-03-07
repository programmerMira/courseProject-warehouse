<?php

namespace App\Http\Controllers;

use App\Http\Requests\LogStoreRequest;
use App\Http\Requests\LogUpdateRequest;
use App\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $logs = Log::with('user')->latest()->get();

        return response()->json($logs);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('log.create');
    }

    /**
     * @param \App\Http\Requests\LogStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(LogStoreRequest $request)
    {
        $request->validated();
        $log = new Log;
        $log->oldValue = $request->input('oldValue');
        $log->newValue = $request->input('newValue');
        $log->userId = \Auth::user()->id;
        $log->save();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Log $log
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Log $log)
    {
        return view('log.show', compact('log'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Log $log
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Log $log)
    {
        return view('log.edit', compact('log'));
    }

    /**
     * @param \App\Http\Requests\LogUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(LogUpdateRequest $request, $id)
    {
        $request->validated();
        $log = Log::find($id);
        $log->oldValue = $request->input('oldValue');
        $log->newValue = $request->input('newValue');
        $log->userId = $request->input('userId');
        $log->save();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $log = Log::find($id);
        $log->delete();
    }
}
