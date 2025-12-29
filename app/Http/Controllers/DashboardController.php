<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Pregnancy;
use App\Models\Child;
use App\Models\Schedule; // Pastikan Anda memiliki model Schedule (Jadwal)
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * DASHBOARD ORANG TUA (KELUARGA)
     */
    public function orangTua()
    {
        $user = Auth::user();
        $patient = $user->patient ? $user->patient()->with('children.growths')->first() : null;

        $nextVisit = null;
        $visitType = 'Belum ada jadwal kontrol';

        if ($patient) {
            // 1. Cek Jadwal dari Tabel Schedule (Manual)
            $manualSchedule = Schedule::where('patient_id', $patient->id)
                ->where('date', '>=', Carbon::today())
                ->orderBy('date', 'asc')
                ->first();

            if ($manualSchedule) {
                $nextVisit = Carbon::parse($manualSchedule->date);
                $visitType = $manualSchedule->title;
            } else {
                // 2. Fallback: Cek Estimasi Otomatis (Latest Pregnancy + 1 Bulan)
                $lastPregnancy = $patient->kehamilans()->latest('updated_at')->first();
                if ($lastPregnancy) {
                    $nextDate = Carbon::parse($lastPregnancy->updated_at)->addMonth();
                    if ($nextDate->isFuture()) {
                        $nextVisit = $nextDate;
                        $visitType = 'Pemeriksaan Rutin Kehamilan';
                    }
                }
            }
        }

        return view('dashboard.orangtua', [
            'patient'   => $patient,
            'articles'  => $this->getEducationContent(),
            'nextVisit' => $nextVisit,
            'visitType' => $visitType
        ]);
    }

    /**
     * DASHBOARD TENAGA MEDIS
     */
    public function tenagaMedis()
    {
        // Statistik Utama
        $stats = [
            'total_pasien'  => Patient::count(),
            'ibu_hamil'     => Pregnancy::distinct('patient_id')->count(),
            'resiko_tinggi' => Pregnancy::whereRaw("CAST(SUBSTRING_INDEX(tekanan_darah, '/', 1) AS UNSIGNED) >= 140")->count(),
            'kunjungan_hari_ini' => Pregnancy::whereDate('updated_at', Carbon::today())->count(),
        ];

        // 1. DAFTAR PASIEN (Untuk Modal Tambah Jadwal)
        // Ini kunci agar fitur "Tambah Jadwal" bisa memilih nama pasien
        $allPatients = Patient::orderBy('nama', 'asc')->get();

        // 2. PEMERIKSAAN TERBARU (Tabel Utama)
        $recentPregnancies = Pregnancy::with('patient')
            ->latest('updated_at')
            ->take(5)
            ->get();

        // 3. AKTIVITAS TERBARU (Log di Sidebar)
        // PERBAIKAN: Hapus filter whereDate(today) agar log tidak kosong jika hari ini belum ada aksi
        $recentActivities = Pregnancy::with('patient')
            ->latest('updated_at')
            ->take(5)
            ->get();

        // 4. JADWAL KONTROL (Sidebar)
        // Mengambil data dari tabel Schedule yang akan datang
        $upcomingSchedules = Schedule::with('patient')
            ->where('date', '>=', Carbon::today())
            ->orderBy('date', 'asc')
            ->take(3)
            ->get();

        return view('dashboard.tenagamedis', [
            'stats'             => $stats,
            'patients'          => $allPatients, // Dikirim untuk dropdown modal
            'recentPregnancies' => $recentPregnancies,
            'todaysActivity'    => $recentActivities, // Sekarang berisi 5 aktivitas terakhir umum
            'upcomingSchedules' => $upcomingSchedules,
            'articles'          => $this->getEducationContent()
        ]);
    }

    /**
     * FUNGSI SIMPAN JADWAL (Manual)
     */
    public function storeJadwal(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'title'      => 'required|string|max:255',
            'date'       => 'required|date',
            'time'       => 'required',
        ]);

        Schedule::create([
            'patient_id' => $request->patient_id,
            'title'      => $request->title,
            'date'       => $request->date,
            'time'       => $request->time,
        ]);

        return redirect()->back()->with('success', 'Jadwal berhasil ditambahkan!');
    }

    /**
     * DATA KONTEN EDUKASI
     */
    private function getEducationContent()
    {
        return [
            [
                'id'       => 1,
                'title'    => 'Tanda Bahaya Kehamilan',
                'category' => 'Ibu Hamil',
                'desc'     => 'Kenali tanda-tanda bahaya yang harus diwaspadai selama kehamilan.',
                'content'  => "Tanda bahaya kehamilan meliputi:\n1. Perdarahan\n2. Bengkak hebat\n3. Demam tinggi\n4. Gerakan janin berkurang.",
                'image'    => 'https://images.unsplash.com/photo-1531983412531-1f49a365ffed?w=500'
            ],
            [
                'id'       => 2,
                'title'    => 'MPASI Pertama Si Kecil',
                'category' => 'Gizi Anak',
                'desc'     => 'Panduan MPASI pertama yang sehat dan sesuai usia.',
                'content'  => "Berikan MPASI mulai usia 6 bulan dengan menu 4 bintang (Karbohidrat, Protein Hewani, Sayur, Lemak).",
                'image'    => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=500'
            ],
            [
                'id'       => 3,
                'title'    => 'Pentingnya Vitamin A',
                'category' => 'Suplemen',
                'desc'     => 'Manfaat vitamin A untuk pertumbuhan dan daya tahan tubuh.',
                'content'  => "Bulan Februari dan Agustus adalah bulan Vitamin A. Pastikan anak mendapatkan kapsul merah/biru.",
                'image'    => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=500'
            ],
        ];
    }
}
