<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequestUser;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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

        if (auth()->attempt($request->only(['email', 'password'])))
         {
            
        } else {

            return response()->json([
                'status_code' => 401,
                'status_message' => 'Nonexistent user',
            ]);
        }

        
        
    }
}
