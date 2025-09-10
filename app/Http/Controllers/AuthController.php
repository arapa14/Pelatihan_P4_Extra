<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Login Berhasil');
        }

        return redirect()->back()->withInput()->with('error', 'login gagal');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logout Berhasil');
    }

    public function dashboard()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        if ($user->role === 'user') {
            return view('user.dashboard');
        } else if ($user->role === 'admin') {
            return view('admin.dashboard');
        } else {
            abort(403);
        }
    }
}
