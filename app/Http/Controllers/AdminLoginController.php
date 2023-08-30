<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    { 
        if(auth()->guard('admin')->check()){
            return redirect()->route('home');
        }
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if(!auth()->guard('admin')->attempt($credentials)){
            return back()->withErrors([
                'message' => 'Wrong credentials please try again'
            ]);
        }

        return redirect()->route('home');
    }

}
