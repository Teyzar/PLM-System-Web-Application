<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lineman;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rule;


class LinemanController extends Controller
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
        $accounts = Lineman::paginate(10);

        return view('lineman')->with('users', $accounts);
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
            'email'    => 'required|email|unique:linemen',
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

            Lineman::create($data);
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
        $person = Lineman::get()->where('id', $id);

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
        $user = Lineman::find($id);
        $rules = [
            'name' => 'required',
            'email'  => Rule::unique('linemen')->ignore($id),
            'baranggay' => 'required'
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        } else {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->baranggay = $request->input('baranggay');
            $user->update();

            Alert::success('', 'Successfully updated');
            return redirect('/lineman');
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

        $delete = Lineman::where('id', $id)->delete();

        toast('Successfully deleted!', 'success');
        return redirect('/lineman');
    }
}
