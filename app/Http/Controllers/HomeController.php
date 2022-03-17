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
            'apiKey' => env('MAPS_KEY', 'AIzaSyA2vqdxEToK1qKnxm14YrCwJ1xoLd1FcBU'),
            'heatmapData' => Unit::all(['id', 'status', 'latitude', 'longitude'])->where('status', 'fault')
        ]);
    }
}
