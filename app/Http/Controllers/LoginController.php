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
        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            // Arahkan sesuai role
            if ($user->role == 'Tenaga Medis') {
                return redirect('/dashboardtenagamedis');
            } else if ($user->role == 'Orang Tua') {
                return redirect('/dashboardorangtua');
            } else {
                return redirect('/');
            }
        }

        return back()->with('error', 'Nama atau Password salah');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
