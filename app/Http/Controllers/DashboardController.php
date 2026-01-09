<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Pregnancy;
use App\Models\VisitSchedule; 
use App\Models\Article;
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

        // --- LOGIKA PENENTUAN JADWAL KUNJUNGAN ---
        $nextVisit = null;
        $visitType = '';

        // 1. CEK JADWAL MANUAL DARI BIDAN (PRIORITAS UTAMA)
        // Cari jadwal yang statusnya 'dijadwalkan' dan tanggalnya hari ini atau masa depan
        $realSchedule = $patient->visitSchedules()
            ->where('status', 'dijadwalkan')
            ->whereDate('tanggal_kunjungan', '>=', Carbon::today())
            ->orderBy('tanggal_kunjungan', 'asc') // Ambil yang paling dekat
            ->first();

        if ($realSchedule) {
            // A. JIKA ADA JADWAL MANUAL -> PAKAI INI
            $nextVisit = $realSchedule->tanggal_kunjungan;
            $visitType = $realSchedule->jenis_kunjungan; // Teks asli dari inputan bidan
        } 
        else {
            // B. JIKA TIDAK ADA JADWAL MANUAL -> PAKAI HITUNGAN OTOMATIS (FALLBACK)
            
            // B1. Cek dari data Kehamilan Terakhir (H+30 hari)
            $lastPregnancyCheck = $patient->kehamilans()->latest('updated_at')->first();
            
            if ($lastPregnancyCheck) {
                $nextDate = Carbon::parse($lastPregnancyCheck->updated_at)->addMonth();
                // Hanya anggap jadwal jika tanggalnya di masa depan
                if ($nextDate->isFuture()) {
                    $nextVisit = $nextDate;
                    $visitType = 'Pemeriksaan Kehamilan (Estimasi)';
                }
            }

            // B2. Cek dari data Imunisasi/Tumbuh Kembang Anak (Bandingkan mana yang lebih dekat)
            foreach ($patient->children as $child) {
                $lastGrowth = $child->growths()->latest('tanggal')->first();
                
                if ($lastGrowth) {
                    $nextChildDate = Carbon::parse($lastGrowth->tanggal)->addMonth();
                    
                    // Jika jadwal anak ini valid (masa depan) DAN (belum ada nextVisit ATAU jadwal anak ini lebih dekat dari jadwal hamil)
                    if ($nextChildDate->isFuture() && ($nextVisit == null || $nextChildDate->lt($nextVisit))) {
                        $nextVisit = $nextChildDate;
                        $visitType = 'Imunisasi & Tumbuh Kembang ('.$child->nama.')';
                    }
                }
            }
        }

        // C. JIKA TETAP KOSONG (Tidak ada manual & Tidak ada history pemeriksaan)
        if (! $nextVisit) {
            // Opsi: Tampilkan tanggal hari ini atau biarkan null (tergantung desain view)
            // Di sini kita set null agar view bisa menampilkan pesan "Belum ada jadwal"
            $nextVisit = null; 
            $visitType = 'Belum ada jadwal terdekat';
        }

        // --- ARTIKEL EDUKASI ---
        $articles = Article::latest()->take(3)->get();

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
            'ibu_hamil' => Pregnancy::distinct('patient_id')->count(),
            'resiko_tinggi' => Pregnancy::get()->filter(function ($p) {
                $tensi = explode('/', $p->tekanan_darah);
                return isset($tensi[0]) && (int) $tensi[0] >= 140;
            })->count(),
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