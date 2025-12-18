<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (auth()->attempt([
        'email' => $request->email,
        'password' => $request->password
    ])) {
        $user = auth()->user();

        return $user->role === 'Tenaga Medis'
            ? redirect('/dashboard/tenagamedis')
            : redirect('/dashboard/orangtua');
    }

    return back()->with('error', 'Email atau password salah.');
}

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
