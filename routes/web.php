<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GolonganController;
use App\Http\Controllers\LemburController;
use App\Http\Controllers\PegawaiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('login.post');
Route::post('logout', [AuthController::class,'logout'])->name('logout');

Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

Route::middleware('auth')->group(function() {
    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::get('/golongan', [GolonganController::class, 'index'])->name('golongan.index');
    Route::get('/lembur', [LemburController::class, 'index'])->name('lembur.index');
});

Route::middleware('isUser')->group(function() {

});

Route::middleware('isAdmin')->group(function() {
    Route::get('/pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');
    Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
    Route::get('/pegawai/{pegawai}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::put('/pegawai/{pegawai}', [PegawaiController::class, 'update'])->name('pegawai.update');
    Route::delete('/pegawai/{pegawai}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');

    Route::get('/golongan/create', [GolonganController::class, 'create'])->name('golongan.create');
    Route::post('/golongan', [GolonganController::class, 'store'])->name('golongan.store');
    Route::get('/golongan/{golongan}/edit', [GolonganController::class, 'edit'])->name('golongan.edit');
    Route::put('/golongan/{golongan}', [GolonganController::class, 'update'])->name('golongan.update');
    Route::delete('/golongan/{golongan}', [GolonganController::class, 'destroy'])->name('golongan.destroy');
});