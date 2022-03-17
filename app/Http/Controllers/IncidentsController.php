<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Unit;

use Illuminate\Http\Request;

class IncidentsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $incidents = Incident::all();
        return view('incidents', ['incidents' => $incidents]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $fields = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'unit_ids' => 'required|array|min:1'
        ]);

        $incident = Incident::create([
            'resolved' => false,
        ]);

        $incident->info()->create([
            'title' => $fields['title'],
            'description' => $fields['description']
        ]);

        $units = Unit::whereIn('id', array_keys($fields['unit_ids']))->where('status', 'fault')->get();
        $incident->units()->sync(array_column($units->toArray(), 'id'));

        return redirect()->back();
    }
}
