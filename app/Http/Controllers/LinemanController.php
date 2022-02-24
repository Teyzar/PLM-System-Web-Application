<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lineman;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;

class LinemanController extends Controller
{
    use RegistersUsers;

    public function index()
    {

        $linemen = Lineman::get();
        $count = $linemen->count();

        if ($count == 0) {
            Lineman::truncate();
        }

        return view('lineman')->with('linemen', $linemen);
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
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'barangay' => $request->barangay,
            'password' => Hash::make("plmsystem")
        ];

        Lineman::create($data);

        toast('Account registered successfully!', 'success');

        return redirect()->back();
    }

    public function show(Request $request, String $id)
    {
        if (!$request->wantsJson()) abort(404);

        $lineman = Lineman::find($id);

        return json_encode($lineman);
    }

    public function update(Request $request, String $id)
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

        toast('Account updated successfully!', 'success');

        return redirect('/lineman');
    }

    public function destroy(String $id)
    {
        Lineman::where('id', $id)->delete();

        toast('Account deleted successfully!', 'success');

        return back();
    }

    public function reset(Request $request, String $id)
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

        toast('Password has been reset!', 'success');

        return json_encode($data['lineman']);
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        $lineman = Lineman::where('email', $fields['email'])->first();
        if (!$lineman) {
            return response([
                'message' => 'These credentials do not match our records.'
            ], 401);
        }

        if (!Hash::check($fields['password'], $lineman->password)) {
            return response([
                'message' => 'The provided password is incorrect.'
            ], 401);
        }

        $token = $lineman->createToken('apiToken')->plainTextToken;

        return response(['token' => $token], 200);
    }
}
