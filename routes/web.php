<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PregnancyController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD (LOGIN REQUIRED)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD ORANG TUA
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard/orangtua', [DashboardController::class, 'orangTua'])
        ->name('dashboard.orangtua');

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD TENAGA MEDIS
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard/tenagamedis', [DashboardController::class, 'tenagaMedis'])
        ->name('dashboard.tenagamedis');


        // Di dalam group middleware 'auth'

    Route::get('/rekam-medis', function () {return view('rm.index'); })->name('rm.index');
    /*
    |--------------------------------------------------------------------------
    | PASIEN (TENAGA MEDIS)     
    |--------------------------------------------------------------------------
    */
    Route::prefix('medis/pasien')->group(function () {
        Route::get('/', [PatientController::class, 'index'])->name('pasien.index');
        Route::get('/tambah', [PatientController::class, 'create'])->name('pasien.create');
        Route::post('/simpan', [PatientController::class, 'store'])->name('pasien.store');
        Route::get('/{id}', [PatientController::class, 'show'])->name('pasien.show');
        Route::get('/{id}/edit', [PatientController::class, 'edit'])->name('pasien.edit');
        Route::post('/{id}/update', [PatientController::class, 'update'])->name('pasien.update');
        Route::delete('/{id}', [PatientController::class, 'destroy'])->name('pasien.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | DATA KEHAMILAN
    |--------------------------------------------------------------------------
    */
    Route::prefix('kehamilan')->group(function () {
        Route::get('/{patient_id}', [PregnancyController::class, 'index'])->name('kehamilan.index');
        Route::get('/{patient_id}/tambah', [PregnancyController::class, 'create'])->name('kehamilan.create');
        Route::post('/simpan', [PregnancyController::class, 'store'])->name('kehamilan.store');

        Route::get('/edit/{id}', [PregnancyController::class, 'edit'])->name('kehamilan.edit');
        Route::post('/update/{id}', [PregnancyController::class, 'update'])->name('kehamilan.update');
    });

    // --- ROUTE PROFILE ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

});
