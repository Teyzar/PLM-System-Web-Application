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
        $apiKey = env('MAPS_KEY', 'AIzaSyA2vqdxEToK1qKnxm14YrCwJ1xoLd1FcBU');
        $heatmapData = Unit::where('status', 'fault')->get(['id', 'status', 'latitude', 'longitude'])->toJson();

        return view('home', compact('apiKey', 'heatmapData'));
    }
}
