<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // =========================
    // FORM REGISTER
    // =========================
    public function registerForm()
    {
        return view('auth.register');
    }

    // =========================
    // PROSES REGISTER
    // =========================
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:5',
            'role'     => 'required'
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil');
    }

    // =========================
    // FORM LOGIN
    // =========================
    public function loginForm()
    {
        return view('auth.login');
    }

    // =========================
    // PROSES LOGIN (PAKAI NAMA)
    // =========================
    public function login(Request $request)
    {
        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {

            if (Auth::user()->role === 'Orang Tua') {
                return redirect()->route('dashboard.orangtua');
            }

            if (Auth::user()->role === 'Tenaga Medis') {
                return redirect()->route('dashboard.tenagamedis');
            }
        }

        return back()->with('error', 'Nama atau password salah');
    }

    // =========================
    // LOGOUT
    // =========================
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
