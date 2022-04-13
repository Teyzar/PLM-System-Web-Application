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
        return view('incidents', [
            'incidents' => Incident::orderBy('created_at', 'desc')->get()
        ]);
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
            'units' => Unit::all()->filter(function ($unit) {
                return $unit->status == 'fault';
            })
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

        $units = Unit::whereIn('id', array_keys($fields['unit_ids']))->filter(function ($unit) {
            return $unit->status == 'fault';
        });

        $incident->units()->sync(array_column($units->toArray(), 'id'));

        return redirect()->back();
    }

    public function destroy($id)
    {
        $destroy = Incident::where('id', $id)->delete();

        return redirect()->back();
    }

    public function edit($id)
    {
        $incident = Incident::find($id);

        $info = $incident->info()->get();

        return $info;
    }

    public function update(Request $request, $id)
    {

        $incident = Incident::find($id);

        $infos = $incident->info()->orderBy('created_at', 'desc')->get();

        $i = 0;
        foreach ($infos as $info) {
            $incident->info()->where('id', $info->id)->update([
                'title' => $request->title[$i],
                'description' => $request->description[$i]
            ]);
            $i++;
        }


        $info = $incident->info()->orderBy('created_at', 'desc')->get();

        return $info;
    }

    public function add(Request $request, $id)
    {
        $fields = $request->validate([
            'title' => 'required|string|min:1',
            'description' => 'required|string|min:1'
        ]);

        $incident = Incident::find($id);

        $info = $incident->info()->create([
            'title' => $fields['title'],
            'description' => $fields['description']
        ]);

        return $info;
    }
}
