<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AddminAcc;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function index () {
        return view('pages.default');
    }
    public function checklogin (Request $request) {
        $accs = DB::table('admin_accs')->get();

        $username = $request->input('user');
        $password = $request->input('pass');


        foreach ($accs as $acc) {
            if ($acc->username == $username && $acc->password == $password) {
                return view('pages.home');
            } else {
                return redirect('/login');
            }
        }
    }
}
