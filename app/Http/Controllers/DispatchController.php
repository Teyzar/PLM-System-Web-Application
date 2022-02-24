<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Lineman;
use RealRashid\SweetAlert\Facades\Alert;

class DispatchController extends Controller
{
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $countLineman = $request->lineman_no;
        $countUnit = $request->unit_no;


        if ($countLineman) {
            foreach ($countLineman as $key => $dataLineman) {
                $selected_lineman = Lineman::where('id', $key)->get();
                foreach ($selected_lineman as $lineman) {
                    $email = [
                        'email' => $lineman->email
                    ];
                    echo '<pre>';
                    print_r($email);
                    echo '</pre>';
                }
            }
        }


        if ($countUnit) {
            foreach ($countUnit as $key => $dataUnit) {
                $selected_unit = Unit::where('id', $key)->get();
                foreach ($selected_unit as $unit) {
                    $phone = [
                        'number' => $unit->phone_number
                    ];
                    echo '<pre>';
                    print_r($phone);
                    echo '</pre>';
                }
            }
        }

        // return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
