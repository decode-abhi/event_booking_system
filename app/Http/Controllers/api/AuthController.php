<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;


class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $accessToken = $user->createToken('new_user');

        return response()->json([
            'access_token' => $accessToken->accessToken,
            'token_type' => 'Bearer',
        ]);

    }

    public function login(Request $request){
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();

        if(! $user || Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'invalid creadentials',
            ],401);
        }
        $accessToken = $user->createToken('existing_user');

        return response()->json([
            'access_token' => $accessToken->accessToken,
            'token_type' => 'Bearer',
        ]);


    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}
