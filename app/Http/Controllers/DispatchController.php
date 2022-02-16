<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Lineman;


class DispatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lineman = Lineman::get();
        $unit = Unit::get();

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
                foreach ($selected_lineman as $data) {
                    dump($data->email);
                }
            }
        }


        if ($countUnit) {
            foreach ($countUnit as $key => $dataUnit) {
                $selected_unit = Unit::where('id', $key)->get();
                foreach ($selected_unit as $unit) {
                    dump($unit->phone_number);
                }
            }
        }
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

    public function search(Request $request)
    {
        if (!$request->ajax()) abort(404);

        $output = "";
        $searchTerm = $request->searchTerm;
        $linemen = Lineman::orderBy('created_at', 'desc')->paginate(10);

        if (!empty($searchTerm)) {
            $linemen = Lineman::where('name', 'LIKE', '%' . $searchTerm . "%")
                ->orWhere('email', 'LIKE', '%' . $searchTerm . "%")
                ->orWhere('barangay', 'LIKE', '%' . $searchTerm . "%")
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        $count = $linemen->count();
        if ($count <= 0) {
            $output .= "
                <tr border-width: 1px;' class='trbody bg-light'>
                    <td class='text-center fs-6 border-top text-danger p-4' colspan ='7'>
                        No Record Found
                    </td>
                </tr>
            ";
        } else {
            foreach ($linemen as $lineman) {
                $output .= "
                    <tr class=''>
                        <th scope='row'><input class='form-check-input cb-lineman' type='checkbox' name='lineman_no[$lineman->id]'></th>
                        <td>$lineman->name</td>
                        <td>$lineman->email</td>
                        <td><i class='fa fa-check-circle-o green'></i><span
                                class='ms-1'>$lineman->barangay</span></td>
                    </tr>
                ";
            }
        }
        $data = array(
            'result' => $output,
            'count' => $count
        );
        return json_encode($data);
    }
}
