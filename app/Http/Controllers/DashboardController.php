<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // =========================
    // DASHBOARD ORANG TUA
    // =========================
    public function orangTua()
    {
        return view('dashboard.orangtua');
    }

    // =========================
    // DASHBOARD TENAGA MEDIS
    // =========================
    public function tenagaMedis()
    {
        // Ambil semua data pasien
        $patients = Patient::orderBy('created_at', 'desc')->get();

        // Kirim ke view
        return view('dashboard.tenagamedis', compact('patients'));
    }
}
