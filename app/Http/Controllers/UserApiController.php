<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'ability:accessUser'])->except(['login']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $request->user();
    }

    /**
     * Log the user in.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user) {
            return response([
                'message' => 'These credentials do not match our records.'
            ], 401);
        }

        if (!Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'The provided password is incorrect.'
            ], 401);
        }

        $token = $user
            ->createToken('userToken', ['accessUser', 'accessUnits', 'editUnits'])
            ->plainTextToken;

        return ['token' => $token];
    }

    /**
     * Log the user out.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return ['message' => 'Logged out!'];
    }
}
