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
        $this->middleware('auth')->except('index');
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
        return view('create-incidents', [
            'apiKey' => env('MAPS_KEY', 'AIzaSyA2vqdxEToK1qKnxm14YrCwJ1xoLd1FcBU'),
            'units' => Unit::where('status', 'fault')->get()
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
            'title' => 'required|string|min:1',
            'description' => 'required|string|min:1',
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
