<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;

// =========================
// ROOT (HOME)
// =========================
Route::get('/', function () {
    return redirect('/login');
});

// =========================
// REGISTER (PAKAI AuthController)
// =========================
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// =========================
// LOGIN (PAKAI LoginController SAJA)
// =========================
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// =========================
// DASHBOARD — BUTUH LOGIN
// =========================
Route::middleware(['auth'])->group(function () {

    // Dashboard Orang Tua
    Route::middleware(['orang_tua'])->group(function () {
        Route::get('/dashboardorangtua', [DashboardController::class, 'orangTua'])
             ->name('dashboard.orangtua');

        Route::get('/dashboard-ortu', function () {
            return view('dashboard_ortu');
        });
    });

    // Dashboard Tenaga Medis
    Route::middleware(['tenaga_medis'])->group(function () {
        Route::get('/dashboardtenagamedis', [DashboardController::class, 'tenagaMedis'])
             ->name('dashboard.tenaga_medis');

        Route::get('/dashboard-med', function () {
            return view('dashboard_med');
        });
    });

});
