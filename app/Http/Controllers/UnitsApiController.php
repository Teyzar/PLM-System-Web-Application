<?php

namespace App\Http\Controllers;

use App\Events\HeatmapUpdate;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitsApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'ability:accessUnits']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $phone_number
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $phone_number)
    {
        if (!$request->user()->tokenCan('editUnits'))
            return abort(401);

        $fields = $request->validate([
            'status' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $unit = Unit::where('phone_number', $phone_number)->first();

        if (!$unit) return abort(404);

        $unit->update([
            'status' => $fields['status'],
            'latitude' => doubleval($fields['latitude']),
            'longitude' => doubleval($fields['longitude'])
        ]);

        event(new HeatmapUpdate($unit));

        return $unit;
    }
}
