<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function Login(Request $request)
    {

        request()->validate([
            'email' => ['required', 'email'],
            'password' => 'required']);
         if (Auth::attempt(request()->only('email', 'password'))) {
             return response()->json([
                'token' => auth()->user()->createToken('token')->accessToken,
            ]);
        }
        return response()->json(["message" => 'wrong credentials'], 422);

    }
}
