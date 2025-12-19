<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\ChildGrowth;
use App\Models\Patient;
use Illuminate\Http\Request;

class ChildController extends Controller
{
    public function index()
    {
        // Ambil semua data anak, urutkan dari yang terbaru
        // 'with('patient')' digunakan agar kita bisa menampilkan nama Ibu di daftar
        $children = Child::with('patient')->latest()->get();

        return view('anak.index', compact('children'));
    }

    // Fungsi untuk menyimpan data anak baru
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'nama' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'berat_lahir' => 'nullable|numeric',
            'tinggi_lahir' => 'nullable|numeric',
        ]);

        // 2. Simpan Data & TANGKAP hasilnya ke variabel $child
        // (Ini kuncinya: kita butuh ID dari anak yang baru dibuat)
        $child = Child::create($validatedData);

        // 3. Redirect langsung ke halaman Detail Anak ($child->id)
        return redirect()->route('anak.show', $child->id)
            ->with('success', 'Data anak berhasil dibuat! Silakan mulai mencatat pertumbuhan.');
    }

    public function create($patient_id)
    {
        // Ambil data Ibu untuk ditampilkan namanya di form
        $patient = Patient::findOrFail($patient_id);

        return view('anak.create', compact('patient'));
    }

    public function show($id)
    {
        // Ambil data anak beserta riwayat pertumbuhannya
        $child = Child::with('growths')->findOrFail($id);

        return view('anak.show', compact('child'));
    }

    public function destroy($id)
    {
        $child = Child::findOrFail($id);
        $patientId = $child->patient_id;

        $child->delete();

        return redirect()->route('pasien.show', $patientId)
            ->with('success', 'Data anak berhasil dihapus.');
    }

    public function storeGrowth(Request $request)
    {
        $request->validate([
            'child_id' => 'required',
            'tanggal' => 'required|date',
            'berat_badan' => 'required|numeric',
            'tinggi_badan' => 'required|numeric',
        ]);

        ChildGrowth::create($request->all());

        return redirect()->back()->with('success', 'Data pertumbuhan berhasil dicatat!');
    }
}
