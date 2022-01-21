<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class MainController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function main() {

        if(Auth::check()){

            return view('authenticated.home');
        }
        return view('auth.login');

    }
}
