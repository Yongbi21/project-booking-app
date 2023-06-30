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
        $priceQuote = PriceQuote::latest()->paginate(10);

        return response()->json(['priceQuote' => $priceQuote], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'project_request_id' => 'required|exists:project_requests,id',
            'project_complexity' => 'required|in:simple,moderate,complex',
            'estimate_time' => 'required|max:255',
            'additional_services' => 'required|max:255',
            'total_amount' => 'required|numeric',
        ]);



        $validatedData['project_complexity'] = ucwords(strtolower($validatedData['project_complexity']));
        $priceQuote = PriceQuote::create($validatedData);
        return response()->json(['priceQuote' => $priceQuote], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PriceQuote  $priceQuote
     * @return \Illuminate\Http\Response
     */
    public function show(PriceQuote $priceQuote)
    {
        return response()->json(['priceQuote' => $priceQuote], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PriceQuote  $priceQuote
     * @return \Illuminate\Http\Response
     */
    // public function edit(PriceQuote $priceQuote)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PriceQuote  $priceQuote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PriceQuote $priceQuote)
    {
        $validatedData = $request->validate([
            'project_request_id' => 'required|exists:project_requests,id',
            'project_complexity' => 'required|in:low,medium,high',
            'estimate_time' => 'required|max:255',
            'additional_services' => 'required|max:255',
            'total_amount' => 'required|numeric',
        ]);


        $priceQuote->update($validatedData);
        return response()->json($priceQuote, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PriceQuote  $priceQuote
     * @return \Illuminate\Http\Response
     */
    public function destroy(PriceQuote $priceQuote)
    {
        $priceQuote->delete();

        return response()->json(null, 204);
    }
}
