<?php

namespace App\Http\Controllers;

use App\Models\Attendence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login(Request $request) {

        
       
        if( Auth::attempt(['email' => $request->email, 'password' => $request->password]) ) {

            $token = $request->user()->createToken('mytoken');
            return response()->json([
                'token' => $token->plainTextToken,
            ], 201);
        }else{
            return response()->json([
                'message' => 'Credential not match!'
            ], 401);
        }

    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(null, 200);
    }

    function register (Request $request) {
        User::create($request->all());
        return response()->json(["message" => "user Created"], 200);
    }
}
