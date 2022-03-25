<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Lineman;
use App\Notifications\Dispatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class DispatchController extends Controller
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
        $lineman = Lineman::all();
        $unit = Unit::all();

        return view('dispatch', [
            'linemans' => $lineman,
            'units' => $unit
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
            'lineman_ids' => 'required|array|min:1',
            'unit_ids' => 'required|array|min:1',
        ]);

        $linemen = Lineman::whereIn('id', array_keys($fields['lineman_ids']))->get();
        $units = Unit::whereIn('id', array_keys($fields['unit_ids']))->get();

        Notification::send($linemen, new Dispatch($units));

        return redirect()->back();
    }
}
