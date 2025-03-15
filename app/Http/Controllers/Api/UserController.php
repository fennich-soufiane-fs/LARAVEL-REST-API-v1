<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequestUser;
use App\Models\User;


class UserController extends Controller
{
    public function register(RegisterRequestUser $request) {
        $user = new User();
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;

        $user->save();
    }
}
