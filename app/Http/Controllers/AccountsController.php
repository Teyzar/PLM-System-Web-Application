<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;


class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $accounts = Accounts::paginate(10);

        return view('accounts')->with('users', $accounts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    protected function validator(array $data)
    {
        return Validator::make($data);
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
            'email'    => 'required|email|unique:accounts',
            'password' => [
                'required',
                'required_with:confirmpass',
                'string',
                'min:8',
            ],
            'confirmpass' => 'required|min:8|same:password',
            'baranggay' => 'required'
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        } else {
            $data = $request->all();

            $data['password'] = Hash::make($data['password']);

            Accounts::create($data);
            // ->withSuccess('Account Succesfully Created!')
            toast('Account Succesfully Created!', 'success');
            return redirect()->back();
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $person = Accounts::get()->where('id', $id);

        return view('profile')->with('data', $person);
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
        $rules = [
            'email'    => 'required|email|unique:accounts',
            'baranggay' => 'required'
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        } else {

            $user = Accounts::find($id);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->baranggay = $request->input('baranggay');

            $user->update();

            Alert::success($request->input('name'), 'Successfully updated');
            return redirect('/accounts');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $delete = Accounts::where('id', $id)->delete();

        toast('Successfully delete!', 'success');
        return redirect('/accounts');
    }
}
