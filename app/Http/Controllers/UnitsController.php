<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $units = Unit::get();
        return view('units')->with('units', $units);
    }

    public function store(Request $request)
    {
        $rules = [
            'phone_number' => 'required|string',
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
}
