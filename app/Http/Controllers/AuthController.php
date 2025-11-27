<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    // ================================
    // FORM REGISTER
    // ================================
    public function registerForm()
    {
        return view('register');
    }

    // ================================
    // PROSES REGISTER
    // ================================
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4',
            'role' => 'required'
        ]);

        // Simpan user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role
        ]);

        // Redirect ke login dengan notifikasi
        return redirect('/login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    // ================================
    // FORM LOGIN
    // ================================
    public function loginForm()
    {
        return view('login');
    }

    // ================================
    // PROSES LOGIN
    // ================================
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


    // ================================
    // LOGOUT
    // ================================
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
