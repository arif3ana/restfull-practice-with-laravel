<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // validasi request data 
        $validate = Validator::make($request->all(), [
            "email" => 'required',
            "password" => 'required'
        ]);

        // jika validasi gagal
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        // mengambil kredensial dari request
        $credentials = $request->only('email', 'password');

        // jika login gagal
        $token = JWTAuth::attempt($credentials);
        if(!$token) {
            return response()->json([
                "success" => false,
                "message" => "Email atau password anda salah!!"
            ], 401);
        }

        // jika login success
        return response()->json([
            "success" => true,
            "user" => auth()->user(),
            'token' => $token
        ], 200);
    }
}
