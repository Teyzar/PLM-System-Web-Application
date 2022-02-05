<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lineman;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class LinemanController extends Controller
{

    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {

        $accounts = Lineman::paginate(10);

        return view('lineman')->with('users', $accounts);
    }


    public function create()
    {
    }

    protected function validator(array $data)
    {
        return Validator::make($data);
    }


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
        } else {
            $request->password = Hash::make("plmsystem");

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'barangay' => $request->barangay,
                'password' => Hash::make("plmsystem")
            ];
            Lineman::create($data);
            toast('Account Succesfully Created!', 'success');
            return redirect()->back();
        }
    }


    public function show($id)
    {
    }

    public function edit(Request $request)
    {
        $person = Lineman::find($request->id);
        return $person;
    }


    public function update(Request $request, $id)
    {
        $user = Lineman::find($id);
        $rules = [
            'updatename' => 'required',
            'updatebarangay' => 'required'
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        } else {
            $user->name = $request->input('updatename');
            $user->email = $request->input('updateemail');
            $user->barangay = $request->input('updatebarangay');
            $user->update();
            Alert::success('', 'Successfully updated');
            return redirect('/lineman');
        }
    }


    public function destroy($id)
    {

        $delete = Lineman::where('id', $id)->delete();

        toast('Successfully deleted!', 'success');
        return back();
    }
}
