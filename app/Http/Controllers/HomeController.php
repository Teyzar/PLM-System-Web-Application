<?php

namespace App\Http\Controllers;

use App\Models\Unit;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home', [
            'apiKey' => env('MAPS_KEY', ''),
            'heatmapData' => Unit::where('status', 'fault')->get(['id', 'status', 'latitude', 'longitude'])
        ]);
    }
}
