<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if (!auth()->attempt($credentials)) {
            abort(401, 'Invalid Credentials');
        }

        $user = $request->user();

        $user->tokens()->delete();

        $token = $user->createToken('invoice');

        return response()->json([
            'token' => $token
        ]);
    }
}
