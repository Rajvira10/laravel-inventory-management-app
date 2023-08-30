<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{   
    //show login page
    public function showlogin()
    {   
        if(auth()->check()){
            return redirect()->route('home');
        }
        return view('auth.login');
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            
            return redirect()->intended(route('home'));
        }
        
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        auth()->logout();
        
        $request->session()->invalidate();
        
        $request->session()->regenerateToken();
        
        return redirect('/');
    }

    //register
    public function register()
    {
        //if logged in
        if(auth()->check()){
            return redirect()->route('home');
        }
        return view('auth.register');
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed',
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email, 
            'password' => Hash::make($request->password),
        ]);
        
        auth()->login($user);
        
        return redirect()->route('home');
    }
}
