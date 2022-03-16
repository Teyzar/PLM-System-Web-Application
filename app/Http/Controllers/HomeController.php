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
            'lat' => 10.94463755493866,
            'lng' => 123.27352044217186
        );

        return view('home', [
            'apiKey' => 'AIzaSyCUkerPRBMbwWZ083ke5NbpQEr9tsKALMo',
            'cadizCity' => json_encode($cadizCity),
            'heatmapData' => Unit::all(['id', 'status', 'latitude', 'longitude'])->where('status', 'fault')
        ]);
    }
}
