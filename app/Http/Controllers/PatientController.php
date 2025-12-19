<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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
    // SIMPAN PASIEN (LOGIKA CERDAS)
    // =========================
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama'      => 'required|string',
            'nik'       => 'required|numeric|unique:patients,nik', // NIK Pasien harus unik
            // PERUBAHAN 1: Hapus 'unique:users' agar email yang sudah terdaftar tidak error
            'email'     => 'required|email', 
            'tgl_lahir' => 'required|date',
            'alamat'    => 'required|string',
            'no_telp'   => 'required|string',
        ]);

        // 2. Gunakan Transaction
        try {
            DB::transaction(function () use ($request) {
                
                // A. CEK APAKAH AKUN USER SUDAH ADA?
                $user = User::where('email', $request->email)->first();
                $isNewAccount = false;
                $umurHitungan = Carbon::parse($request->tgl_lahir)->age;

                if ($user) {
                    // === SKENARIO 1: AKUN SUDAH ADA ===
                    // Cek apakah akun ini sudah terhubung ke pasien lain?
                    if ($user->patient) {
                        throw new \Exception('Email ini sudah terdaftar sebagai pasien atas nama: ' . $user->patient->nama);
                    }
                    
                    // Jika belum terhubung, kita pakai $user ini.
                    // Password TIDAK diubah (tetap password lama milik ortu).
                    
                    // Opsional: Pastikan role-nya 'orangtua'
                    if ($user->role !== 'orangtua') {
                        $user->update(['role' => 'orangtua']);
                    }

                } else {
                    // === SKENARIO 2: AKUN BELUM ADA (BUAT BARU) ===
                    $user = User::create([
                        'name'     => $request->nama,
                        'email'    => $request->email,
                        'password' => Hash::make($request->nik), // Password default NIK
                        'role'     => 'orangtua',
                    ]);
                    $isNewAccount = true;
                }

                // B. BUAT DATA PASIEN (Linked ke User ID yang ditemukan/dibuat)
                Patient::create([
                    'user_id'   => $user->id, // Sambungkan ke ID user (baik lama maupun baru)
                    'nama'      => $request->nama,
                    'nik'       => $request->nik,
                    'umur'      => $umurHitungan,
                    'tgl_lahir' => $request->tgl_lahir,
                    'alamat'    => $request->alamat,
                    'no_telp'   => $request->no_telp,
                ]);

                // Simpan status untuk pesan notifikasi
                session()->flash('status_akun', $isNewAccount ? 'baru' : 'lama');
            });

            // Pesan sukses yang dinamis
            $message = session('status_akun') == 'baru' 
                ? 'Pasien ditambahkan & Akun baru dibuat (Password: NIK).' 
                : 'Pasien ditambahkan & Berhasil dihubungkan ke akun Orang Tua yang sudah ada.';

            return redirect()->route('pasien.index')->with('success', $message);

        } catch (\Exception $e) {
            // Jika ada error (misal email sudah dipakai pasien lain), kembalikan ke form
            return back()->withInput()->withErrors(['email' => $e->getMessage()]);
        }
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
            'nik'     => 'required|string|unique:patients,nik,'.$patient->id,
            // 'umur' bisa dihapus dari validasi jika dihitung otomatis dari tgl_lahir
            // tapi jika kolom umur ada di DB, biarkan saja.
            'alamat'  => 'required|string',
            'no_telp' => 'required|string',
        ]);

        $patient->update($validated);

        return redirect()
            ->route('pasien.show', $patient->id)
            ->with('success', 'Data pasien berhasil diperbarui');
    }

    // =========================
    // HAPUS PASIEN
    // =========================
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        
        // Karena ada onDelete('cascade') di migrasi User->Patient,
        // Kita cek dulu: Apakah kita mau menghapus AKUN LOGIN-nya juga?
        
        // Opsi A: Hapus Pasien Saja (Akun login tetap ada, tapi jadi "yatim")
        // $patient->delete();

        // Opsi B (Rekomendasi): Hapus Akun Loginnya juga (Otomatis pasien terhapus via cascade)
        // Ini lebih bersih agar tidak ada akun "hantu" tanpa data pasien
        if($patient->user) {
            $patient->user->delete(); 
        } else {
            $patient->delete();
        }

        return redirect()->route('pasien.index')
            ->with('success', 'Data pasien dan akun terkait berhasil dihapus!');
    }
}