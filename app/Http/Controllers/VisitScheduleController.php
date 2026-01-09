<?php

namespace App\Http\Controllers;

use App\Models\VisitSchedule;
use Illuminate\Http\Request;
use App\Models\Patient;


class VisitScheduleController extends Controller
{
    // 1. MENAMPILKAN SEMUA JADWAL (Menu Utama)
    public function index()
    {
        // Ambil jadwal yang belum selesai (dijadwalkan) ditaruh paling atas
        // Lalu urutkan berdasarkan tanggal terdekat
        $schedules = VisitSchedule::with('patient')
            ->orderByRaw("FIELD(status, 'dijadwalkan', 'selesai', 'batal')")
            ->orderBy('tanggal_kunjungan', 'asc')
            ->get();

        return view('jadwal.index', compact('schedules'));
    }

    // 2. SIMPAN JADWAL BARU (Dari Modal di Halaman Detail Pasien)
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'jenis_kunjungan' => 'required|string',
            'tanggal_kunjungan' => 'required|date', // Boleh set 'after:today' jika tidak boleh tanggal lampau
            'catatan' => 'nullable|string|max:255',
        ]);

        VisitSchedule::create([
            'patient_id' => $request->patient_id,
            'jenis_kunjungan' => $request->jenis_kunjungan,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'status' => 'dijadwalkan',
            'catatan' => $request->catatan,
        ]);

        return redirect()->back()->with('success', 'Jadwal kunjungan berhasil dibuat!');
    }

    // 3. UPDATE STATUS (Tandai Selesai / Batalkan)
    public function updateStatus(Request $request, $id)
    {
        $schedule = VisitSchedule::findOrFail($id);

        // Validasi input status hanya boleh 'selesai' atau 'batal'
        if (in_array($request->status, ['selesai', 'batal'])) {
            $schedule->update(['status' => $request->status]);

            $msg = $request->status == 'selesai' ? 'Kunjungan diselesaikan.' : 'Kunjungan dibatalkan.';

            return redirect()->back()->with('success', $msg);
        }

        return redirect()->back()->with('error', 'Status tidak valid.');
    }

    public function create(Request $request)
    {
        // Jika ada parameter ?patient_id=1 di URL, kita ambil datanya
        $selectedPatient = null;
        if ($request->has('patient_id')) {
            $selectedPatient = Patient::find($request->patient_id);
        }

        // Ambil semua pasien untuk dropdown (jika tidak via detail pasien)
        $patients = Patient::select('id', 'nama', 'nik')->orderBy('nama')->get();

        return view('jadwal.create', compact('patients', 'selectedPatient'));
    }

    public function edit($id)
    {
        $schedule = VisitSchedule::with('patient')->findOrFail($id);

        return view('jadwal.edit', compact('schedule'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_kunjungan' => 'required|date',
            'jenis_kunjungan' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $schedule = VisitSchedule::findOrFail($id);

        $schedule->update([
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'jenis_kunjungan' => $request->jenis_kunjungan,
            'catatan' => $request->catatan,
        ]);

        // Redirect kembali ke halaman pasien agar user tidak bingung
        return redirect()->route('pasien.show', $schedule->patient_id)
            ->with('success', 'Jadwal kunjungan berhasil diperbarui!');
    }
}
