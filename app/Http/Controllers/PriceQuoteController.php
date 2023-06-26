<?php

namespace App\Http\Controllers;

use App\Models\PriceQuote;
use Illuminate\Http\Request;

class PriceQuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PriceQuote  $priceQuote
     * @return \Illuminate\Http\Response
     */
    public function show(PriceQuote $priceQuote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PriceQuote  $priceQuote
     * @return \Illuminate\Http\Response
     */
    public function edit(PriceQuote $priceQuote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PriceQuote  $priceQuote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PriceQuote $priceQuote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PriceQuote  $priceQuote
     * @return \Illuminate\Http\Response
     */
    public function destroy(PriceQuote $priceQuote)
    {
        // return response()->json(null, 204);
    }
}
