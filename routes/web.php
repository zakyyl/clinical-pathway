<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\HivController;
use App\Http\Controllers\BphController;
use App\Http\Controllers\DmController;
use App\Http\Controllers\DypsController;
use App\Http\Controllers\JntgController;
use App\Http\Controllers\PebController;
use App\Http\Controllers\TyphController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StatistikController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard.index'); 
    }

    return redirect()->route('login');
});


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/dashboard/recent', [DashboardController::class, 'recent'])->name('dashboard.recent');
Route::get('/dashboard/alldata', [DashboardController::class, 'alldata'])->name('dashboard.alldata');

Route::get('/pasien', [PasienController::class, 'index'])->middleware('auth')->name('pasien.index');

Route::get('/hiv', [HivController::class, 'index'])->name('hiv.index');
Route::get('/hiv/create', [HivController::class, 'create'])->name('hiv.create');
Route::post('/hiv', [HivController::class, 'store'])->name('hiv.store');

Route::get('/bph', [BphController::class, 'index'])->name('bph.index');
Route::get('/bph/create', [BphController::class, 'create'])->name('bph.create');
Route::post('/bph', [BphController::class, 'store'])->name('bph.store');

Route::get('/peb', [PebController::class, 'index'])->name('peb.index');
Route::get('/peb/create', [PebController::class, 'create'])->name('peb.create');
Route::post('/peb', [PebController::class, 'store'])->name('peb.store');

Route::get('/dm', [DmController::class, 'index'])->name('dm.index');
Route::get('/dm/create', [DmController::class, 'create'])->name('dm.create');
Route::post('/dm', [DmController::class, 'store'])->name('dm.store');

Route::get('/jntg', [JntgController::class, 'index'])->name('jntg.index');
Route::get('/jntg/create', [JntgController::class, 'create'])->name('jntg.create');
Route::post('/jntg', [JntgController::class, 'store'])->name('jntg.store');

Route::get('/typh', [TyphController::class, 'index'])->name('typh.index');
Route::get('/typh/create', [TyphController::class, 'create'])->name('typh.create');
Route::post('/typh', [TyphController::class, 'store'])->name('typh.store');

Route::get('/dyps', [DypsController::class, 'index'])->name('dyps.index');
Route::get('/dyps/create', [DypsController::class, 'create'])->name('dyps.create');
Route::post('/dyps', [DypsController::class, 'store'])->name('dyps.store');

Route::get('/peb/{no_rawat}/pdf', [PebController::class, 'exportPdf'])->where('no_rawat', '.*')->name('peb.pdf');
Route::get('/hiv/{no_rawat}/pdf', [HivController::class, 'exportPdf'])->where('no_rawat', '.*')->name('hiv.pdf');
Route::get('/dm/{no_rawat}/pdf', [DmController::class, 'exportPdf'])->where('no_rawat', '.*')->name('dm.pdf');
Route::get('/bph/{no_rawat}/pdf', [bphController::class, 'exportPdf'])->where('no_rawat', '.*')->name('bph.pdf');
Route::get('/typh/{no_rawat}/pdf', [TyphController::class, 'exportPdf'])->where('no_rawat', '.*')->name('typh.pdf');
Route::get('/jntg/{no_rawat}/pdf', [JntgController::class, 'exportPdf'])->where('no_rawat', '.*')->name('jntg.pdf');
Route::get('/dyps/{no_rawat}/pdf', [DypsController::class, 'exportPdf'])->where('no_rawat', '.*')->name('dyps.pdf');

Route::post('/hiv/find-patient', [HivController::class, 'findPatient'])->name('hiv.find');
Route::post('/bph/find-patient', [BphController::class, 'findPatient'])->name('bph.find');
Route::post('/peb/find-patient', [PebController::class, 'findPatient'])->name('peb.find');
Route::post('/dm/find-patient', [DmController::class, 'findPatient'])->name('dm.find');
Route::post('/jntg/find-patient', [JntgController::class, 'findPatient'])->name('jntg.find');
Route::post('/typh/find-patient', [TyphController::class, 'findPatient'])->name('typh.find');
Route::post('/dyps/find-patient', [DypsController::class, 'findPatient'])->name('dyps.find');

Route::get('/hiv/{no_rawat}/detail', [HivController::class, 'show'])->where('no_rawat', '.*')->name('hiv.show');
Route::get('/bph/{no_rawat}/detail', [BphController::class, 'show'])->where('no_rawat', '.*')->name('bph.show');
Route::get('/peb/{no_rawat}/detail', [PebController::class, 'show'])->where('no_rawat', '.*')->name('peb.show');
Route::get('/dm/{no_rawat}/detail', [DmController::class, 'show'])->where('no_rawat', '.*')->name('dm.show');
Route::get('/jntg/{no_rawat}/detail', [JntgController::class, 'show'])->where('no_rawat', '.*')->name('jntg.show');
Route::get('/typh/{no_rawat}/detail', [TyphController::class, 'show'])->where('no_rawat', '.*')->name('typh.show');
Route::get('/dyps/{no_rawat}/detail', [DypsController::class, 'show'])->where('no_rawat', '.*')->name('dyps.show');

Route::delete('/hiv/{id}', [HivController::class, 'destroy'])->name('hiv.destroy');
Route::delete('/bph/{id}', [BphController::class, 'destroy'])->name('bph.destroy');
Route::delete('/peb/{id}', [PebController::class, 'destroy'])->name('peb.destroy');
Route::delete('/dm/{id}', [DmController::class, 'destroy'])->name('dm.destroy');
Route::delete('/jntg/{id}', [JntgController::class, 'destroy'])->name('jntg.destroy');
Route::delete('/typh/{id}', [TyphController::class, 'destroy'])->name('typh.destroy');
Route::delete('/dyps/{id}', [DypsController::class, 'destroy'])->name('dyps.destroy');

Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__ . '/auth.php';
