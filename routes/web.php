<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\HivController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StatistikController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/pasien', [PasienController::class, 'index'])
    ->middleware('auth')
    ->name('pasien.index');

Route::get('/hiv', [HivController::class, 'index'])->name('hiv.index');
Route::get('/hiv/create', [HivController::class, 'create'])->name('hiv.create');
Route::post('/hiv', [HivController::class, 'store'])->name('hiv.store');

// ajax cari pasien
Route::post('/hiv/find-patient', [HivController::class, 'findPatient'])->name('hiv.find');


 Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik.index');

// // AJAX: Cari pasien
// Route::post('/hiv/find-patient', [HivController::class, 'findPatient'])
//     ->name('clinical.hiv.findPatient');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
