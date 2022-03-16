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
        $cadizCity = array(
            'lat' => 10.95583493620157,
            'lng' => 123.30611654802884
        );

        return view('home', [
            'apiKey' => env('MAPS_KEY', 'AIzaSyA2vqdxEToK1qKnxm14YrCwJ1xoLd1FcBU'),
            'cadizCity' => json_encode($cadizCity),
            'heatmapData' => Unit::all(['id', 'status', 'latitude', 'longitude'])->where('status', 'fault')
        ]);
    }
}
