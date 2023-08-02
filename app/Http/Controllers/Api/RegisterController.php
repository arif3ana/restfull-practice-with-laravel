<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // request validasi register
        $validate = Validator::make($request->all(), [
            "name" => 'required',
            'email' => 'required|email|unique:users',
            "password" => 'required|max:7|confirmed'
        ]);

        // Jika validasi gagal / fails
        if($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        //create user jika validation success 
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password)
        ]);

        // mengembalikan respons json jika user berhasil di create
        if($user) {
            return response()->json([
                "success" => true,
                "user" => $user
            ], 201);
        }

        // mengembalikan respons json jika user gagal di create
        return response()->json([
            "success" => false
        ], 409);
    }
}
