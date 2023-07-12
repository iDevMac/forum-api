<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class AuthController extends Controller
{

    public function dashboard()
    {
        return "Welcome";
    }

    public function register(RegisterRequest $request)
    {
        $request->validated();
        $userData = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        $user = User::create($userData);
        $token = $user->createToken('forumapp')->plainTextToken;

        return response([
            "success" => true,
            "msg" => "Registeration Successful",
            "data" => $user,
            "token" => $token
         ], 201);
    }

    public function login(LoginRequest $request)
    {
        $request->validated();
        $user = User::whereUsername($request->username)->first();
        if ($user || Hash::check($request->password, $user->password)) {
            $token = $user->createToken('forumapp')->plainTextToken;
            return response([
                "success" => true,
                "msg" => "Login successful",
                "user" => $user->username,
                "token" => $token
            ], 200);
        }else{
            return response([
                "success" => false,
                "msg" => "invalid credentials",
            ], 422);
        }

    }
}
