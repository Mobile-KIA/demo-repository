<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Pregnancy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // =========================
    // DASHBOARD ORANG TUA
    // =========================
    public function orangTua()
    {
        $user = Auth::user();
        $patient = $user->patient;

        if (! $patient) {
            return view('dashboard.orangtua_empty');
        }

        // --- LOGIKA HITUNG JADWAL KUNJUNGAN ---
        // Asumsi: Jadwal kontrol adalah 1 bulan (30 hari) setelah pemeriksaan terakhir
        $nextVisit = null;
        $visitType = '';

        // 1. Cek dari data Kehamilan Terakhir
        $lastPregnancyCheck = $patient->kehamilans()->latest('updated_at')->first();
        if ($lastPregnancyCheck) {
            $nextDate = Carbon::parse($lastPregnancyCheck->updated_at)->addMonth();
            if ($nextDate->isFuture()) {
                $nextVisit = $nextDate;
                $visitType = 'Pemeriksaan Kehamilan';
            }
        }

        // 2. Cek dari data Imunisasi/Tumbuh Kembang Anak Terakhir
        // (Jika jadwal anak lebih dekat daripada jadwal hamil, tampilkan jadwal anak)
        foreach ($patient->children as $child) {
            $lastGrowth = $child->growths()->latest('tanggal')->first();
            if ($lastGrowth) {
                $nextChildDate = Carbon::parse($lastGrowth->tanggal)->addMonth();
                // Jika jadwal anak ini lebih dekat (lebih kecil) dari jadwal yang sudah ada
                if ($nextChildDate->isFuture() && ($nextVisit == null || $nextChildDate->lt($nextVisit))) {
                    $nextVisit = $nextChildDate;
                    $visitType = 'Imunisasi & Tumbuh Kembang ('.$child->nama.')';
                }
            }
        }

        // Jika tidak ada data checkup sebelumnya, set default (misal: Hari ini/Segera)
        if (! $nextVisit) {
            $nextVisit = Carbon::now();
            $visitType = 'Kunjungan Rutin';
        }

        // --- ARTIKEL EDUKASI ---
        $articles = [
            ['title' => 'Tanda Bahaya Kehamilan', 'category' => 'Ibu Hamil', 'desc' => 'Kenali tanda-tanda bahaya yang harus diwaspadai...'],
            ['title' => 'MPASI Pertama Si Kecil', 'category' => 'Gizi Anak', 'desc' => 'Menu rekomendasi untuk 6 bulan pertama...'],
            ['title' => 'Pentingnya Vitamin A', 'category' => 'Suplemen', 'desc' => 'Manfaat vitamin A untuk mata dan kekebalan tubuh...'],
        ];

        return view('dashboard.orangtua', compact('patient', 'articles', 'nextVisit', 'visitType'));
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

                return isset($tensi[0]) && (int) $tensi[0] >= 140;
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
