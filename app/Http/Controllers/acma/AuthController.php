<?php

namespace App\Http\Controllers\acma;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required|min:3'
        ]);

        $request['email'] = mb_strtoupper($request['email']);
        //dd($request->only('email', 'password'), Hash::make($request['password']));
        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withErrors(['error' => 'Email ou senha invalidos!'])->withInput();
        }

        return redirect()->route('home');
    }

    public function logout() {
        Auth::logout();

        return redirect()->route('login');
    }


}
