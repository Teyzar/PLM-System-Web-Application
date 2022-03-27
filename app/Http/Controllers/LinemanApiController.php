<?php

namespace App\Http\Controllers;

use App\Models\Lineman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LinemanApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'ability:accessLineman'])->except(['login']);
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
        if (!$request->user()->tokenCan('editLineman' . $id))
            return abort(401);

        $fields = $request->validate([
            'fcm_token' => 'string',
            'password' => 'string|min:8'
        ]);

        $lineman = Lineman::find($id);
        if (!$lineman) abort(404);

        $hasChanges = false;
        if ($fields['fcm_token']) {
            $lineman->fcm_token = $fields['fcm_token'];
            $hasChanges = true;
        }
        if ($fields['password']) {
            $lineman->password = Hash::make($fields['password']);
            $hasChanges = true;
        }

        if (!$hasChanges) abort(400);
        $lineman->update();

        return $lineman;
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
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
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

        $lineman->token = $lineman
            ->createToken('linemanToken', ['accessLineman', 'editLineman' . $lineman->id])
            ->plainTextToken;

        return $lineman;
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
