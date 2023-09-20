<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required',
            'fullname' => 'required',
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);


        User::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        if(!Auth::attempt($request->only('email', 'password'))){
            return response()->json([
                'success' => false,
                'message' => 'Invalid login details',
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth_token')->accessToken;

        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }

    public function getUser()
    {
        $user = User::find(Auth::user()->id);


        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    public function logout()
    {
        auth()->user()->token()->revoke();

        return response()->json([
            'success' => true,
            'message' => 'You have been successfully logged out',
        ]);
    }
}
