<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    // =========================
    // LIST PASIEN
    // =========================
    public function index()
    {
        $patients = Patient::latest()->get();
        return view('pasien.index', compact('patients'));
    }

    // =========================
    // FORM TAMBAH PASIEN
    // =========================
    public function create()
    {
        return view('pasien.create');
    }

    // =========================
    // SIMPAN PASIEN
    // =========================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'    => 'required|string|max:255',
            'nik'     => 'required|string|unique:patients,nik',
            'umur'    => 'required|integer',
            'alamat'  => 'required|string',
            'no_telp' => 'required|string'
        ]);

        Patient::create($validated);

        return redirect()
            ->route('dashboard.tenagamedis')
            ->with('success', 'Data pasien berhasil ditambahkan');
    }

    // =========================
    // DETAIL PASIEN
    // =========================
    public function show($id)
    {
        $patient = Patient::findOrFail($id);
        return view('pasien.show', compact('patient'));
    }

    // =========================
    // FORM EDIT PASIEN
    // =========================
    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        return view('pasien.edit', compact('patient'));
    }

    // =========================
    // UPDATE PASIEN
    // =========================
    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $validated = $request->validate([
            'nama'    => 'required|string|max:255',
            'nik'     => 'required|string|unique:patients,nik,' . $patient->id,
            'umur'    => 'required|integer',
            'alamat'  => 'required|string',
            'no_telp' => 'required|string'
        ]);

        $patient->update($validated);

        return redirect()
            ->route('pasien.show', $patient->id)
            ->with('success', 'Data pasien berhasil diperbarui');
    }
    public function destroy($id)
{
    // 1. Cari data berdasarkan ID, jika tidak ketemu akan error 404
    $patient = Patient::findOrFail($id);

    // 2. (Opsional) Hapus data relasi jika perlu (misal: data kehamilan)
    // $patient->kehamilans()->delete(); 

    // 3. Hapus data pasien
    $patient->delete();

    // 4. Kembali ke halaman index dengan pesan sukses
    return redirect()->route('pasien.index')
        ->with('success', 'Data pasien berhasil dihapus!');
}
}
