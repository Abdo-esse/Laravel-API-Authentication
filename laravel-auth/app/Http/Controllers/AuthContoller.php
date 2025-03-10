<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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

    public function user()
    {
        return 'Authenticade user';
    }
}
