<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function login(Request $request) {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {

            $user=User::where("email",$credentials['email'])->first();
            
            $token=$user->createToken("mykey")->plainTextToken; 

            return response()->json(["user"=>$user,"token"=>$token]);
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
        
    }

    public function logout() {
        auth()->logout();
        // Auth::logout();        
    }
}