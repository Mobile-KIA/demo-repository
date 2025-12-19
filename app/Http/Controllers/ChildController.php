<?php

namespace App\Http\Controllers;

use App\Models\Child;
use Illuminate\Http\Request;

class ChildController extends Controller
{
    // Fungsi untuk menyimpan data anak baru
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'nama' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'berat_lahir' => 'nullable|numeric',
            'tinggi_lahir' => 'nullable|numeric',
        ]);

        Child::create($request->all());

        // Kembali ke halaman detail pasien sebelumnya
        return redirect()->back()->with('success', 'Data anak berhasil ditambahkan!');
    }
}