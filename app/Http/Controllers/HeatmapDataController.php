<?php

namespace App\Http\Controllers;

use App\Events\HeatmapDel;
use App\Events\HeatmapSet;
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

        $unit = HeatmapData::where('phone_number', $fields['phone_number'])->first();

        if ($unit) {
            $unit->update($request->all());
        } else {
            HeatmapData::create($request->all());
        }

        $unit = HeatmapData::where('phone_number', $fields['phone_number'])->first();

        event(new HeatmapSet($unit));

        return $unit;
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

        if ($unit) {
            event(new HeatmapDel($fields['phone_number']));
            HeatmapData::destroy($unit->id);
        }

        return response('');
    }
}
