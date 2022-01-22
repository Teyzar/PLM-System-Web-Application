<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class MainController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function main() {
        return view('authenticated.home');
    }
    public function accounts() {

        return view('authenticated.accounts');
    }
    public function units() {

        return view('authenticated.units');
    }
}
