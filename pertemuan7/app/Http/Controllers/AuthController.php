<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.signIn');
    }
    
    public function authenticate(Request $request): RedirectResponse //: RedirectResponse is return type
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->route('home.index');
        }
 
        return back()->withErrors([
            'email' => 'Email anda tidak terdaftar',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }

    public function signUp()
    {
        return view('auth.signUp');

    }

    public function storeMember(Request $request): RedirectResponse //: RedirectResponse is return type
    {
        $credentials = $request->validate([
            'nama' => ['required'],
            'username' => ['required'],
            'email' => ['required', 'email'],
            'profile_img' => ['required'],
            'password' => ['required', 'min:6'],
            'confirm_password' => ['required', 'min:6'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->route('home.index');
        }
 
        return back()->withErrors([
            'email' => 'Email anda tidak terdaftar',
        ])->onlyInput('email');
    }
}
