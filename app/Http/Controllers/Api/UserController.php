<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequestUser;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Exception;


class UserController extends Controller
{
    public function register(RegisterRequestUser $request) {

        try {
            $user = new User();
        
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password, [
                'rounds' => 12
            ]);

            $user->save();
            return response()->json([
                'status_code' => 200,
                'status_message' => 'User registred successfully',
                'user' => $user
            ]);
        } catch (Exception $e) {
        return response()->json([
            'status_code' => 500,
            'status_message' => 'An error occurred.',
            'error' => $e->getMessage()
        ], 500);

        
        }
    }

    public function login(LoginUserRequest $request) {

        if (Auth::attempt($request->only(['email','password']))) {
            $user = Auth::user();

            // Utilisation de config() au lieu de env()
            $tokenName = config('app.token_secret_key');
            $token = $user->createToken($tokenName)->plainTextToken;

            return response()->json([
                'status_code' => 200,
                'status_message' => 'User connected successfully',
                'user' => $user,
                'token' => $token
            ]);
        } 

        return response()->json([
            'status_code' => 401,
            'status_message' => 'Invalid credentials. Please check your email and password.',
        ]);        
    }
}
