<?php

use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\NilaiAkademikController;
use App\Http\Controllers\PendidikController;
use App\Http\Controllers\SantriController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TahunAjaranController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/santri', [SantriController::class, 'index'])->middleware('auth')->name('santri.index');
Route::get('/santri/create', [SantriController::class, 'create'])->middleware('auth')->name('santri.createSantri');
Route::post('/santri', [SantriController::class, 'store'])->middleware('auth')->name('santri.store');
Route::get('/santri/{id}/edit', [SantriController::class, 'edit'])->name('santri.editSantri');
Route::put('/santri/{id}', [SantriController::class, 'update'])->name('santri.update');
Route::delete('/santri/{id}', [SantriController::class, 'destroy'])->name('santri.destroy');

// Tahun Ajaran
Route::get('tahunajaran', [TahunAjaranController::class, 'index'])->name('tahunajaran.index');
Route::post('tahunajaran', [TahunAjaranController::class, 'store'])->name('tahunajaran.store');
Route::put('tahunajaran/{id}', [TahunAjaranController::class, 'update'])->name('tahunajaran.update');
Route::delete('tahunajaran/{id}', [TahunAjaranController::class, 'destroy'])->name('tahunajaran.destroy');

// Subjects CRUD
// Mata Pelajaran
Route::get('/matapelajaran', [MataPelajaranController::class, 'index'])->name('matapelajaran.index');
Route::post('/matapelajaran', [MataPelajaranController::class, 'store'])->name('matapelajaran.store');
Route::put('/matapelajaran/{id}', [MataPelajaranController::class, 'update'])->name('matapelajaran.update');
Route::delete('/matapelajaran/{id}', [MataPelajaranController::class, 'destroy'])->name('matapelajaran.destroy');

// Pendidik CRUD
Route::get('/pendidik', [PendidikController::class, 'index'])->name('pendidik.index');
Route::get('/pendidik/{id}', [PendidikController::class, 'show'])->name('pendidik.show');
Route::post('/pendidik', [PendidikController::class, 'store'])->name('pendidik.store');
Route::put('/pendidik/{id}', [PendidikController::class, 'update'])->name('pendidik.update');
Route::delete('/pendidik/{id}', [PendidikController::class, 'destroy'])->name('pendidik.destroy');

// Nilai Akademik CRUD
Route::get('/nilaiakademik', [NilaiAkademikController::class, 'index'])
    ->middleware('auth')
    ->name('nilaiakademik.index');

Route::post('/nilaiakademik', [NilaiAkademikController::class, 'store'])
    ->middleware('auth')
    ->name('nilaiakademik.store');

Route::put('/nilaiakademik/{id}', [NilaiAkademikController::class, 'update'])
    ->middleware('auth')
    ->name('nilaiakademik.update');

Route::delete('/nilaiakademik/{id}', [NilaiAkademikController::class, 'destroy'])
    ->middleware('auth')
    ->name('nilaiakademik.destroy');