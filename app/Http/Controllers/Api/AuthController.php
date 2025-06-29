<?php
// app/Http/Controllers/Api/AuthController.php

//namespace App\Http\Controllers\Api;

//use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use App\Models\User;

// class AuthController extends Controller
//{
   // public function login(Request $request)
   // {
        //$credentials = $request->validate([
        //    'email' => 'required|email',
         //   'password' => 'required',
        //]);

        //if (Auth::attempt($credentials)) {
           // $user = Auth::user();
            //$token = $user->createToken('app-token')->plainTextToken;

           // return response()->json([
             //   'user' => $user,
             //   'token' => $token
            //]);
       // }

        //return response()->json([
        //    'message' => 'Invalid credentials'
       // ], 401);
   // }
//}



// app/Http/Controllers/Api/AuthController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'account_number' => 'required_without:email',
            'email' => 'required_without:account_number|email',
            'password' => 'required',
        ]);

        $field = $request->has('email') ? 'email' : 'account_number';
        $credentials = [
            $field => $request->input($field),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'token' => $token,
                'user' => $user,
                'isAdmin' => $user->role === 'admin',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials',
        ], 401);
    }

    // Other methods like register, logout...
}
