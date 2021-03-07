<?php

namespace App\Http\Controllers;


use App\Product;
use App\DetailsCard;
use App\Transport;
use Illuminate\Http\Request;

class HtmlController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function welcome(Request $request)
    {
        $contracts = Product::select('waybillTitle')->groupBy('waybillTitle')->get();
        $transport = Transport::select('title')->groupBy('title')->get();

        return view('welcome', compact('contracts', 'transport'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function main(Request $request)
    {
        $contracts = Product::select('waybillTitle')->groupBy('waybillTitle')->get();
        $transports = Transport::select('title')->groupBy('title')->get();

        return view('tabs.income', compact('contracts', 'transports'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function deals(Request $request)
    {
        $contracts = Product::select('waybillTitle')->groupBy('waybillTitle')->get();
        $transports = Transport::select('title')->groupBy('title')->get();

        return view('tabs.deals', compact('contracts', 'transports'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request)
    {
        $contracts = Product::select('waybillTitle')->groupBy('waybillTitle')->get();
        $transports = Transport::select('title')->groupBy('title')->get();

        return view('tabs.details', compact('contracts', 'transports'));
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function givers(Request $request)
    {
        $contracts = Product::select('waybillTitle')->groupBy('waybillTitle')->get();
        $transports = Transport::select('title')->groupBy('title')->get();

        return view('tabs.givers', compact('contracts', 'transports'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function detail_dict(Request $request)
    {
        $contracts = Product::select('waybillTitle')->groupBy('waybillTitle')->get();
        $transports = Transport::select('title')->groupBy('title')->get();

        return view('tabs.detail_dict', compact('contracts', 'transports'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function cards(Request $request)
    {
        $contracts = Product::select('waybillTitle')->groupBy('waybillTitle')->get();
        $transports = Transport::select('title')->groupBy('title')->get();

        return view('tabs.cards', compact('contracts', 'transports'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function users(Request $request)
    {
        $contracts = Product::select('waybillTitle')->groupBy('waybillTitle')->get();
        $transports = Transport::select('title')->groupBy('title')->get();

        return view('tabs.users', compact('contracts', 'transports'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function history(Request $request)
    {
        $contracts = Product::select('waybillTitle')->groupBy('waybillTitle')->get();
        $transports = Transport::select('title')->groupBy('title')->get();

        return view('history', compact('contracts', 'transports'));
    }

    public function transport(Request $request)
    {
        $contracts = Product::select('waybillTitle')->groupBy('waybillTitle')->get();
        $transports = Transport::select('title')->groupBy('title')->get();

        return view('tabs.transports', compact('contracts', 'transports'));
    }

}
