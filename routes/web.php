<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PregnancyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ImmunizationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ROOT (GUEST)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD & FITUR UTAMA (LOGIN REQUIRED)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // --- DASHBOARD ROLE ---
    // Dashboard Utama (Bisa ditambahkan logic redirect otomatis di controller)
    Route::get('/dashboard/orangtua', [DashboardController::class, 'orangTua'])->name('dashboard.orangtua');
    Route::get('/dashboard/tenagamedis', [DashboardController::class, 'tenagaMedis'])->name('dashboard.tenagamedis');

    // --- FITUR JADWAL (Baru ditambahkan agar bisa simpan data) ---
    Route::post('/jadwal/store', [DashboardController::class, 'storeJadwal'])->name('jadwal.store');

    // =====================================================================
    // GROUP KHUSUS TENAGA MEDIS (Prefix URL: /medis/...)
    // =====================================================================
    Route::prefix('medis')->group(function () {

        // 1. MENU UTAMA REKAM MEDIS
        Route::get('/rekam-medis', function () {
            return view('rm.index');
        })->name('rm.index');

        // 2. MANAJEMEN PASIEN (IBU)
        Route::prefix('pasien')->group(function () {
            Route::get('/', [PatientController::class, 'index'])->name('pasien.index');
            Route::get('/tambah', [PatientController::class, 'create'])->name('pasien.create');
            Route::post('/simpan', [PatientController::class, 'store'])->name('pasien.store');
            Route::get('/{id}', [PatientController::class, 'show'])->name('pasien.show');
            Route::get('/{id}/edit', [PatientController::class, 'edit'])->name('pasien.edit');
            Route::put('/{id}', [PatientController::class, 'update'])->name('pasien.update');
            Route::delete('/{id}', [PatientController::class, 'destroy'])->name('pasien.destroy');
        });

        // 3. MANAJEMEN ANAK (TUMBUH KEMBANG)
        Route::prefix('anak')->group(function () {
            Route::get('/', [ChildController::class, 'index'])->name('anak.index');
            Route::get('/tambah/{patient_id}', [ChildController::class, 'create'])->name('anak.create');
            Route::post('/simpan', [ChildController::class, 'store'])->name('anak.store');
            Route::get('/{id}', [ChildController::class, 'show'])->name('anak.show');
            Route::post('/tumbuh-kembang', [ChildController::class, 'storeGrowth'])->name('anak.growth.store');

            // Imunisasi
            Route::post('/imunisasi/simpan', [ImmunizationController::class, 'store'])->name('imunisasi.store');
            Route::delete('/imunisasi/{id}', [ImmunizationController::class, 'destroy'])->name('imunisasi.destroy');

            Route::delete('/{id}', [ChildController::class, 'destroy'])->name('anak.destroy');
        });

        // 4. MANAJEMEN KEHAMILAN
        Route::prefix('kehamilan')->group(function () {
            Route::get('/riwayat/{patient_id}', [PregnancyController::class, 'index'])->name('kehamilan.index');
            Route::get('/tambah/{patient_id}', [PregnancyController::class, 'create'])->name('kehamilan.create');
            Route::post('/simpan', [PregnancyController::class, 'store'])->name('kehamilan.store');
            Route::get('/edit/{id}', [PregnancyController::class, 'edit'])->name('kehamilan.edit');
            Route::put('/update/{id}', [PregnancyController::class, 'update'])->name('kehamilan.update');
            Route::delete('/{id}', [PregnancyController::class, 'destroy'])->name('kehamilan.destroy');
        });

    }); // End Group Medis

    // --- ROUTE PROFILE (UMUM) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // =====================================================================
    // GROUP KHUSUS ORANG TUA (Prefix URL: /orangtua/...)
    // =====================================================================
    Route::prefix('orangtua')->group(function () {
        // 1. MANAJEMEN DATA ANAK
        Route::get('/anak/{id}', [ChildController::class, 'show'])->name('ortu.anak.show');

        // 2. MANAJEMEN KEHAMILAN
        Route::get('/kehamilan', [PregnancyController::class, 'index'])->name('ortu.kehamilan.index');
        Route::get('/kehamilan/tambah', [PregnancyController::class, 'create'])->name('ortu.kehamilan.create');
        Route::post('/kehamilan/simpan', [PregnancyController::class, 'store'])->name('ortu.kehamilan.store');

        // 3. KONTEN EDUKASI (Detail Artikel)
        Route::get('/edukasi/{id}', function($id){
            // Logic ini bisa dipindah ke DashboardController jika artikel diambil dari DB
            return view('edukasi.show', compact('id'));
        })->name('edukasi.show');
    });
});
