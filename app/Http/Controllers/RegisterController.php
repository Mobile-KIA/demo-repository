<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        // 🔥 LOGIN OTOMATIS SETELAH REGISTER
        Auth::login($user);

        // 🔥 REDIRECT SESUAI ROLE (INI KUNCINYA)
        if ($user->role === 'Tenaga Medis') {
            return redirect('/dashboard/tenagamedis');
        }

        return redirect('/dashboard/orangtua');
    }
}
