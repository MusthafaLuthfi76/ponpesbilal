<?php

use App\Http\Controllers\HalaqahController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\NilaiAkademikController;
use App\Http\Controllers\PendidikController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\SetoranController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\NilaiTahfidzController;

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
Route::put('/santri/{nis}/update-tahunajaran', [SantriController::class, 'updateTahunAjaran'])->name('santri.updateTahunAjaran');
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

/*
|--------------------------------------------------------------------------
| Kelompok Halaqah
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Halaqah list
    Route::get('/halaqah', [HalaqahController::class, 'index'])->name('halaqah.index');

    // Create
    Route::post('/halaqah', [HalaqahController::class, 'store'])->name('halaqah.store');

    // Update
    Route::put('/halaqah/{id}', [HalaqahController::class, 'update'])->name('halaqah.update');

    // Delete
    Route::delete('/halaqah/{id}', [HalaqahController::class, 'destroy'])->name('halaqah.destroy');

    // Detail halaman 1 kelompok
    Route::get('/halaqah/{id}', [HalaqahController::class, 'show'])->name('halaqah.show');

    // Proses hapus santri dari kelompok
    Route::delete('/halaqah/{id_halaqah}/remove-santri/{nis}', [HalaqahController::class, 'removeSantri'])
        ->name('halaqah.removeSantri');

    // Halaman tambah santri ke kelompok
    Route::get('/halaqah/{id_halaqah}/add-santri', [HalaqahController::class, 'showAddSantri'])
        ->name('halaqah.showAddSantri');

    // Proses tambah santri ke kelompok
    Route::post('/halaqah/{id_halaqah}/add-santri', [HalaqahController::class, 'addSantri'])
        ->name('halaqah.addSantri');


    /*
    |--------------------------------------------------------------------------
    | Setoran
    |--------------------------------------------------------------------------
    */

    // List setoran 1 santri
    Route::get('/setoran/{nis}', [SetoranController::class, 'index'])->name('setoran.index');

    // Store setoran
    Route::post('/setoran/{nis}', [SetoranController::class, 'store'])->name('setoran.store');

    // Update setoran
    Route::put('/setoran/{nis}/{id_setoran}', [SetoranController::class, 'update'])->name('setoran.update');

    // Delete setoran
    Route::delete('/setoran/{nis}/{id_setoran}', [SetoranController::class, 'destroy'])->name('setoran.destroy');

    Route::get('/nilaiTahfidz', [NilaiTahfidzController::class, 'index'])->name('nilaiTahfidz.index');
    Route::get('/nilaiTahfidz/{id}/detail', [NilaiTahfidzController::class, 'show'])->name('nilaiTahfidz.show');
    Route::post('/nilaiTahfidz', [NilaiTahfidzController::class, 'store'])->name('nilaiTahfidz.store');
    Route::put('/nilaiTahfidz/{id}', [NilaiTahfidzController::class, 'update'])->name('nilaiTahfidz.update');
    Route::delete('/nilaiTahfidz/{id}', [NilaiTahfidzController::class, 'destroy'])->name('nilaiTahfidz.destroy');

});