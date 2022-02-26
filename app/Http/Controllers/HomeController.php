<?php

namespace App\Http\Controllers;

use App\Models\Unit;

class HomeController extends Controller
{
    public function index()
    {
        $cadizCity = array(
            'lat' => 10.94463755493866,
            'lng' => 123.27352044217186
        );

        return view('home', [
            'apiKey' => 'AIzaSyA2vqdxEToK1qKnxm14YrCwJ1xoLd1FcBU',
            'cadizCity' => json_encode($cadizCity),
            'heatmapData' => Unit::all(['id', 'active', 'latitude', 'longitude'])->where('active', false)
        ]);
    }
}
