<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\GolonganController;
use App\Http\Controllers\LemburController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::get('/golongan', [GolonganController::class, 'index'])->name('golongan.index');
    Route::get('/lembur', [LemburController::class, 'index'])->name('lembur.index');
    Route::get('/gaji', [GajiController::class, 'index'])->name('gaji.index');
});

Route::middleware('isUser')->group(function () {

});

Route::middleware('isAdmin')->group(function () {
    // Pegawai
    Route::get('/pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');
    Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
    Route::get('/pegawai/{pegawai}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::put('/pegawai/{pegawai}', [PegawaiController::class, 'update'])->name('pegawai.update');
    Route::delete('/pegawai/{pegawai}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');

    // Golongan
    Route::get('/golongan/create', [GolonganController::class, 'create'])->name('golongan.create');
    Route::post('/golongan', [GolonganController::class, 'store'])->name('golongan.store');
    Route::get('/golongan/{golongan}/edit', [GolonganController::class, 'edit'])->name('golongan.edit');
    Route::put('/golongan/{golongan}', [GolonganController::class, 'update'])->name('golongan.update');
    Route::delete('/golongan/{golongan}', [GolonganController::class, 'destroy'])->name('golongan.destroy');

    // Lembur
    Route::get('/lembur/create', [LemburController::class, 'create'])->name('lembur.create');
    Route::post('/lembur', [LemburController::class, 'store'])->name('lembur.store');
    Route::get('/lembur/{lembur}/edit', [LemburController::class, 'edit'])->name('lembur.edit');
    Route::put('/lembur/{lembur}', [LemburController::class, 'update'])->name('lembur.update');
    Route::delete('/lembur/{lembur}', [LemburController::class, 'destroy'])->name('lembur.destroy');

    // Gaji
    Route::get('/gaji/create', [GajiController::class, 'create'])->name('gaji.create');
    Route::post('/gaji', [GajiController::class, 'store'])->name('gaji.store');
    Route::get('/gaji/{gaji}/edit', [GajiController::class, 'edit'])->name('gaji.edit');
    Route::put('/gaji/{gaji}', [GajiController::class, 'update'])->name('gaji.update');
    Route::delete('/gaji/{gaji}', [GajiController::class, 'destroy'])->name('gaji.destroy');

    // User
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    // Setting
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/setting/update', [SettingController::class, 'update'])->name('setting.update');
});