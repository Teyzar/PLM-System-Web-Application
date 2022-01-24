<?php

namespace App\Http\Controllers;

use App\Models\HeatmapData;
use Illuminate\Http\Request;

class HeatmapDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return HeatmapData::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'phone_number' => 'required'
        ]);

        return HeatmapData::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HeatmapData  $heatmapData
     * @return \Illuminate\Http\Response
     */
    public function show(HeatmapData $heatmapData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HeatmapData  $heatmapData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HeatmapData $heatmapData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HeatmapData  $heatmapData
     * @return \Illuminate\Http\Response
     */
    public function destroy(HeatmapData $heatmapData)
    {
        //
    }
}
