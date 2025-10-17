<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //Register function
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());

        return response()->json([
            "id" => $user->id,
            "name" => $user->name,
            "email" => $user->email,
            "created_at" => $user->created_at
        ], 201);
    }

    //Login function
    public function login(LoginRequest $request) {
        $validatedData = $request->validated();

        $user = User::where("email", $validatedData["email"])->first();

        if(!$user || !Hash::check($validatedData["password"], $user->password)) {
            return response()->json([
                "message" => "Invalid credentials"
            ], 401);
        }

        $token = $user->createToken("auth_token")->plainTextToken;

        return response()->json([
            "token" => $token,
            "user_id" => $user->id,
            "user" => $user
        ]);
    }

    //Logout function
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->noContent();
    }
}
