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
        $fields = $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'phone_number' => 'required'
        ]);

        $unit = HeatmapData::where('phone_number', $fields['phone_number'])->first();;

        if ($unit) {
            return $unit->update($request->all());
        } else {
            return HeatmapData::create($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $fields = $request->validate([
            'phone_number' => 'required'
        ]);

        $unit = HeatmapData::where('phone_number', $fields['phone_number'])->first();

        if ($unit) HeatmapData::destroy($unit->id);

        return response('');
    }
}
