<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request) {

        $fields=$request->validate([
            "name"=>"required|string",
            "email"=>"required|unique:users,email",
            "password"=>"required|confirmed"
        ]);

        $user=User::create([
            "name"=>$fields['name'],
            "email"=>$fields['email'],
            "password"=>bcrypt($fields['password'])
        ]);

        $token=$user->createToken("mykey")->plainTextToken;

        return response()->json(["user"=>$user,"token"=>$token]);
        
    }
}