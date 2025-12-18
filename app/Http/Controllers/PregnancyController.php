<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Pregnancy;

class PregnancyController extends Controller
{
    // =========================
    // RIWAYAT KEHAMILAN
    // =========================
    public function index($patient_id)
    {
        $patient = Patient::with(['kehamilans' => function ($q) {
            $q->orderBy('created_at', 'desc');
        }])->findOrFail($patient_id);

        return view('kehamilan.index', compact('patient'));
    }

    // =========================
    // FORM TAMBAH DATA
    // =========================
    public function create($patient_id)
    {
        $patient = Patient::findOrFail($patient_id);
        return view('kehamilan.create', compact('patient'));
    }

    // =========================
    // SIMPAN DATA KEHAMILAN
    // =========================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'     => 'required|exists:patients,id',
            'usia_kehamilan' => 'required|numeric',
            'berat_badan'    => 'required|numeric',
            'tinggi_badan'   => 'required|numeric',
            'tekanan_darah'  => 'required',
            'keluhan'        => 'nullable|string'
        ]);

        Pregnancy::create($validated);

        return redirect()
            ->route('kehamilan.index', $request->patient_id)
            ->with('success', 'Data kehamilan berhasil ditambahkan');
    }

    // =========================
    // FORM EDIT KEHAMILAN
    // =========================
    public function edit($id)
    {
        $pregnancy = Pregnancy::findOrFail($id);
        return view('kehamilan.edit', compact('pregnancy'));
    }

    // =========================
    // UPDATE KEHAMILAN
    // =========================
    public function update(Request $request, $id)
    {
        $pregnancy = Pregnancy::findOrFail($id);

        $validated = $request->validate([
            'usia_kehamilan' => 'required|numeric',
            'berat_badan'    => 'required|numeric',
            'tinggi_badan'   => 'required|numeric',
            'tekanan_darah'  => 'required',
            'keluhan'        => 'nullable|string'
        ]);

        $pregnancy->update($validated);

        return redirect()
            ->route('kehamilan.index', $pregnancy->patient_id)
            ->with('success', 'Data kehamilan berhasil diperbarui');
    }
}
