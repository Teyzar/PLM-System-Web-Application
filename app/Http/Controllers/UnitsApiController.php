<?php

namespace App\Http\Controllers;

use App\Events\HeatmapUpdate;
use App\Events\UnitUpdate;
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
            'location' => 'required|string|starts_with:$GPRMC,',
        ]);

        $unit = Unit::where('phone_number', $phone_number)->first();

        if (!$unit) return abort(404);

        // Parse GPRMC NMEA Data
        list($id, $utc, $posStatus, $lat, $latDir, $lng, $lngDir, $gndSpeed, $trkTrue, $date, $magVar, $magVarDir) = explode(',', $fields['location']);

        // Latitude
        $latitude = $lat / 100;
        $latitude_degrees = explode('.', $latitude)[0];
        $latitude_minutes = $lat - ($latitude_degrees * 100);
        $latitude_seconds = ($latitude_minutes / 60);
        $latitude = $latitude_degrees + $latitude_seconds;
        if ($latDir == 'S') $latitude *= -1;

        // Longitude
        $longitude = $lng / 100;
        $longitude_degrees = explode('.', $longitude)[0];
        $longitude_minutes = $lng - ($longitude_degrees * 100);
        $longitude_seconds = ($longitude_minutes / 60);
        $longitude = $longitude_degrees + $longitude_seconds;
        if ($lngDir == 'W') $longitude *= -1;

        $unit->update([
            'status' => $fields['status'],
            'latitude' => doubleval($latitude),
            'longitude' => doubleval($longitude)
        ]);

        event(new UnitUpdate($unit));
        event(new HeatmapUpdate($unit));

        return $unit;
    }

    public function heatmap(Request $request)
    {
        return Unit::where('status', 'fault')->get(['id', 'status', 'latitude', 'longitude']);
    }
}
