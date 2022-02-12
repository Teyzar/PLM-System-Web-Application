<?php

namespace App\Http\Controllers;

use App\Events\HeatmapUpdate;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitsController extends Controller
{
    public function index()
    {
        $units = Unit::get();

        return view('units')->with('units', $units);
    }

    public function create()
    {
        return view('add_unit');
    }

    public function store(Request $request)
    {

        $rules = [
            'phone_number' => 'required|unique:units',
        ];
        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        } else {
            Unit::create([
                'active' => false,
                'phone_number' => $request->phone_number
            ]);

            toast('Unit Succesfully Registered!', 'success');

            return redirect()->back();
        }
    }

    public function update(Request $request, String $phone_number)
    {
        $statusCode = 400;

        $fields = $request->validate([
            'active' => 'required|boolean',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $unit = Unit::where('phone_number', $phone_number)->first();

        if ($unit) {
            $unit->update([
                'active' => $fields['active'],
                'latitude' => $fields['latitude'],
                'longitude' => $fields['longitude']
            ]);

            event(new HeatmapUpdate($unit));

            $statusCode = 200;
        }

        return response('', $statusCode);
    }

    public function clear()
    {
        Unit::all()->delete();

        toast('Data succesfully cleared.', 'success');

        return redirect()->back();
    }
}
