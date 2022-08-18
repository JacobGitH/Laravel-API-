<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){
        $form = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        $form['password']= bcrypt($form['password']);

        $user = User::create($form);
        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,

        ];

        return response($response, 201);
    }

    public function login(Request $request){
        $form = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $form['email'])->first();

        if(!$user || !Hash::check($form['password'], $user->password)){
            return response(['Message' => 'wrong email/pwd'], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,

        ];

        return response($response, 201);
    }

    public function logout(){
        auth()->user()->tokens()->delete();

        return  [
            'message' => 'logged out',
        ];

    }
}
