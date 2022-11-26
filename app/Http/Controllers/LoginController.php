<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function Login(Request $request)
    {
        $validator = validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => 'required']);
        if ($validator->fails()) {
            return $validator->errors();
        }
        if (Auth::attempt(request()->only('email', 'password'))) {
            $user = Auth::user();
            $user->token = $user->createToken('token')->accessToken;
            return response()->json([
                'message' => true,
                'data' => $user
            ]);
        }
        return response()->json(["message" => 'wrong credentials'], 401);

    }
}
