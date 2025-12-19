<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PregnancyController;
use App\Http\Controllers\ProfileController;
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
    Route::get('/dashboard/orangtua', [DashboardController::class, 'orangTua'])->name('dashboard.orangtua');
    Route::get('/dashboard/tenagamedis', [DashboardController::class, 'tenagaMedis'])->name('dashboard.tenagamedis');

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
            // Gunakan PUT untuk update (pastikan di view ada @method('PUT'))
            Route::put('/{id}', [PatientController::class, 'update'])->name('pasien.update');
            Route::delete('/{id}', [PatientController::class, 'destroy'])->name('pasien.destroy');
        });

        // 3. MANAJEMEN ANAK (TUMBUH KEMBANG)
        Route::prefix('anak')->group(function () {
            // Index (Daftar Semua Anak) - PENTING untuk menu RM
            Route::get('/', [ChildController::class, 'index'])->name('anak.index');

            // Tambah Anak (Butuh ID Ibu)
            Route::get('/tambah/{patient_id}', [ChildController::class, 'create'])->name('anak.create');
            Route::post('/simpan', [ChildController::class, 'store'])->name('anak.store');

            // Detail & Fitur Tumbuh Kembang
            Route::get('/{id}', [ChildController::class, 'show'])->name('anak.show');
            Route::post('/tumbuh-kembang', [ChildController::class, 'storeGrowth'])->name('anak.growth.store');

            // Hapus Anak
            Route::delete('/{id}', [ChildController::class, 'destroy'])->name('anak.destroy');
        });

        // 4. MANAJEMEN KEHAMILAN
        Route::prefix('kehamilan')->group(function () {
            // Daftar kehamilan per pasien
            Route::get('/riwayat/{patient_id}', [PregnancyController::class, 'index'])->name('kehamilan.index');

            // Tambah Data
            Route::get('/tambah/{patient_id}', [PregnancyController::class, 'create'])->name('kehamilan.create');
            Route::post('/simpan', [PregnancyController::class, 'store'])->name('kehamilan.store');

            // Edit & Update
            Route::get('/edit/{id}', [PregnancyController::class, 'edit'])->name('kehamilan.edit');
            Route::put('/update/{id}', [PregnancyController::class, 'update'])->name('kehamilan.update');

            // Hapus (Opsional)
            Route::delete('/{id}', [PregnancyController::class, 'destroy'])->name('kehamilan.destroy');
        });

    }); // End Group Medis

    // --- ROUTE PROFILE (UMUM) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

});
