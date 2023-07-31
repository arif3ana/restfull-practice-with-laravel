<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();

        return new UserResource(true, 'Data Pengguna', $user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = validator::make($request->all(), [
            "name" => "required",
            "email" => "required",
            "password" => "required",
        ]);

        if ($data->fails()) {
            return response()->json($data->errors(), 422);
        }

        $register = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password,
        ]);

        return new UserResource(true, "Registrasi berhasil", $register);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where("id", $id)->get();
        return new UserResource(true, "ada", $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $data = validator::make($request->all(), [
            "name" => "required",
            "email" => "required",
            "password" => "required",
        ]);

        if ($data->fails()) {
            return response()->json($data->errors(), 422);
        }

        $user_update = User::find($id);
        $user_update->update([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password,
        ]);

        return new UserResource(true, "Berhasil di update!", $user_update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        return new UserResource(true, "Berhasil di hapus", null );
    }
}
