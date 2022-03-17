<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;


class IncidentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('incidents');
    }

    public function create()
    {

        $cadizCity = array(
            'lat' => 10.94463755493866,
            'lng' => 123.27352044217186
        );

        $units = Unit::where('status', 'fault')->get();

        return view('create-incidents', [
            'apiKey' => env('MAPS_KEY', 'AIzaSyA2vqdxEToK1qKnxm14YrCwJ1xoLd1FcBU'),
            'cadizCity' => json_encode($cadizCity),
            'heatmapData' => Unit::all(['id', 'status', 'latitude', 'longitude'])->where('status', 'fault'),
            'units' => $units
        ]);
    }
}
