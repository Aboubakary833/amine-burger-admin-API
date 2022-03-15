<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index() {
        return view('login');
    }

    public function login(Request $request) {
        $credentials = $request->all(['email', 'password']);
        if(!Auth::attempt($credentials, $request->remember)) {
            return redirect()->back()->with('error', "Email ou mot de passe incorrect!");
        }

        $request->session()->regenerate();
        return redirect()->route('index');
    }
}
