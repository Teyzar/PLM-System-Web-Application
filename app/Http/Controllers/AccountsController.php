<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class AccountsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $accounts = User::get();


        return view('accounts')->with('users', $accounts);
    }
}
