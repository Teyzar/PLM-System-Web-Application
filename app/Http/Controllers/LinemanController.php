<?php

namespace App\Http\Controllers;

use App\Models\Lineman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class LinemanController extends Controller
{
    use RegistersUsers;

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
        $linemen = Lineman::get();
        $count = $linemen->count();

        if ($count == 0) {
            Lineman::truncate();
        }

        return view('lineman')->with('linemen', $linemen);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email'    => 'required|email|unique:linemen',
            'barangay' => 'required'
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'barangay' => $request->barangay,
            'password' => Hash::make("plmsystem")
        ];

        Lineman::create($data);

        // toast('Account registered successfully!', 'success');
        Alert::success('Success', 'Account registered successfully!');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if (!$request->ajax()) abort(404);

        $lineman = Lineman::find($id);

        return $lineman;
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
        $lineman = Lineman::find($id);

        $rules = [
            'updatename' => 'required',
            'updatebarangay' => 'required'
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        }

        $lineman->name = $request->input('updatename');
        $lineman->email = $request->input('updateemail');
        $lineman->barangay = $request->input('updatebarangay');

        $lineman->update();

        // toast('Account updated successfully!', 'success');
        Alert::success('Success', 'Account updated successfully!');


        return redirect('/lineman');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Lineman::where('id', $id)->delete();

        // toast('Account deleted successfully!', 'success');
        Alert::success('Success', 'Account deleted successfully!');


        return back();
    }

    public function reset(Request $request, $id)
    {
        $lineman = Lineman::find($id);
        $checkbox = $request->checkbox;
        $data = array(
            'lineman' => $lineman,
            'checkbox' => $checkbox
        );

        if ($checkbox === "0") {
            return json_encode($data['checkbox']);
        }

        $lineman->password = Hash::make("plmsystem");
        $lineman->update();

        // toast('Password has been reset!', 'success');
        Alert::success('Success', 'Password has been reset!');


        return $data['lineman'];
    }
}
