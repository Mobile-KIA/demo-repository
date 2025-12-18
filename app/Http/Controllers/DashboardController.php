<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\Pregnancy;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // =========================
    // DASHBOARD ORANG TUA
    // =========================
    public function orangTua()
    {
    // 1. Cari data Pasien berdasarkan User yang login
    // Asumsi: Nama di tabel Users sama dengan Nama di tabel Patients
    // (Idealnya nanti ada kolom user_id di tabel patients)
    $patient = Patient::where('nama', auth()->user()->name)->first();

    // Default values jika data belum ada
    $data = [
        'patient' => $patient,
        'latestCheckup' => null,
        'current_week' => 0,
        'progress_percent' => 0,
        'hpl' => '-',
        'next_visit' => null,
        'history' => collect([]),
    ];

    if ($patient) {
        // Ambil pemeriksaan terakhir
        $latestCheckup = $patient->kehamilans()->latest()->first();
        
        // Ambil riwayat lengkap
        $history = $patient->kehamilans()->latest()->get();

        if ($latestCheckup) {
            // LOGIC MENGHITUNG KEHAMILAN SAAT INI
            // Karena data di DB adalah snapshot waktu itu, kita hitung selisih hari dari update terakhir
            $daysSinceCheckup = \Carbon\Carbon::parse($latestCheckup->created_at)->diffInDays(now());
            $weeksAdded = floor($daysSinceCheckup / 7);
            
            $currentWeek = $latestCheckup->usia_kehamilan + $weeksAdded;
            
            // Batasi max 40 minggu untuk tampilan progress
            $currentWeekCap = $currentWeek > 40 ? 40 : $currentWeek; 

            // Hitung Estimasi HPL (Hari Perkiraan Lahir)
            // Rumus: Tanggal Periksa + Sisa Minggu (40 - Usia Saat Periksa)
            $remainingWeeks = 40 - $latestCheckup->usia_kehamilan;
            $hpl = \Carbon\Carbon::parse($latestCheckup->created_at)->addWeeks($remainingWeeks);

            // Prediksi Kunjungan Berikutnya (Misal: 1 bulan setelah periksa terakhir)
            $nextVisit = \Carbon\Carbon::parse($latestCheckup->created_at)->addMonth();

            $data['latestCheckup'] = $latestCheckup;
            $data['current_week'] = $currentWeek;
            $data['progress_percent'] = ($currentWeekCap / 40) * 100;
            $data['hpl'] = $hpl->translatedFormat('d F Y'); // Format Indonesia
            $data['next_visit'] = $nextVisit;
            $data['history'] = $history;
        }
    }

    return view('dashboard.orangtua', $data);
    }

    // =========================
    // DASHBOARD TENAGA MEDIS
    // =========================
    public function tenagaMedis()
    {
        // 1. STATISTIK KARTU ATAS
        $stats = [
            'total_pasien' => Patient::count(),
            
            // Anggap "Ibu Hamil" adalah pasien yang punya data kehamilan
            'ibu_hamil' => Pregnancy::distinct('patient_id')->count(),
            
            // Logika Sederhana Resiko Tinggi: Jika Tensi Systolic > 140 (Contoh: 150/90)
            // Kita filter manual menggunakan collection untuk simplifikasi query string
            'resiko_tinggi' => Pregnancy::get()->filter(function ($p) {
                $tensi = explode('/', $p->tekanan_darah);
                return isset($tensi[0]) && (int)$tensi[0] >= 140;
            })->count(),

            // Kunjungan hari ini = Data kehamilan yang diupdate/dibuat hari ini
            'kunjungan_hari_ini' => Pregnancy::whereDate('updated_at', Carbon::today())->count(),
        ];

        // 2. TABEL PASIEN TERBARU (5 Data Terakhir diupdate)
        $recentPregnancies = Pregnancy::with('patient')
                                ->latest('updated_at')
                                ->take(5)
                                ->get();

        // 3. JADWAL HARI INI (Data yang diinput hari ini)
        $todaysActivity = Pregnancy::with('patient')
                                ->whereDate('updated_at', Carbon::today())
                                ->latest('updated_at')
                                ->take(3)
                                ->get();

        return view('dashboard.tenagamedis', compact('stats', 'recentPregnancies', 'todaysActivity'));
    }
}
