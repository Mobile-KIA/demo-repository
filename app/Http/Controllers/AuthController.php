<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // =========================
    // FORM REGISTER (UMUM)
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5',
            // Pastikan input role di view register sesuai value-nya ('medis' atau 'orangtua')
            'role' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    // =========================
    // FORM LOGIN
    // =========================
    public function loginForm()
    {
        return view('auth.login');
    }

    // =========================
    // PROSES LOGIN (REVISI: PAKAI EMAIL)
    // =========================
    public function login(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            'email' => ['required', 'email'], // Ubah 'name' jadi 'email'
            'password' => ['required'],
        ]);

        // 2. Coba Login
        if (Auth::attempt($credentials)) {

            // 3. Regenerate Session (Wajib untuk keamanan)
            $request->session()->regenerate();

            // 4. Cek Role & Redirect
            // Pastikan penulisan string role SAMA PERSIS dengan di database
            // Di PatientController kita pakai 'orangtua' (kecil semua, tanpa spasi)

            $role = Auth::user()->role;

            if ($role === 'orangtua') {
                return redirect()->route('dashboard.orangtua');
            }

            if ($role === 'medis' || $role === 'Tenaga Medis') {
                // Handle dua kemungkinan penulisan biar aman
                return redirect()->route('dashboard.tenagamedis');
            }

            // Default redirect jika role lain (misal admin)
            return redirect('/');
        }

        // 5. Jika Gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // =========================
    // LOGOUT
    // =========================
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate session untuk keamanan
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
