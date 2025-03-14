<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;
class AuthContoller extends Controller
{

     public function register(Request $request)
     {
         return User::create([
             'name'=>$request->input('name'),
             'email'=>$request->input('email'),
             'password'=>bcrypt($request->input('password')),
         ]);
     }

     public function login(Request $request)
     {
        if (!Auth::attempt($request->only('email','password'))){
            return response([
                'message'=>'Invalid Credentials'
            ], Response::HTTP_UNAUTHORIZED);

        }
        $user = Auth::user();
        $tokenResult = $user->createToken('Token')->plainTextToken;
        $cookie = cookie('jwt', $tokenResult, 60*24);
        return response([
            'message'=>$tokenResult
        ])->withCookie($cookie);
     }

    public function user()
    {
        return Auth::User();
    }

    public function logout(){
         $cookie = Cookie::forget('jwt');
         return response ([
             'message'=>'Logged out'
         ])->withCookie($cookie);
    }
}
