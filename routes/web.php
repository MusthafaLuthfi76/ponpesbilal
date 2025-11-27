<?php

use App\Http\Controllers\HalaqahController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\NilaiAkademikController;
use App\Http\Controllers\NilaiKesantrianController;
use App\Http\Controllers\NilaiMapelController;
use App\Http\Controllers\PendidikController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\SetoranController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\NilaiTahfidzController;
use App\Http\Controllers\RaporController;  


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
Route::get('tahunajaran', [TahunAjaranController::class, 'index'])->middleware('auth')->name('tahunajaran.index');
Route::post('tahunajaran', [TahunAjaranController::class, 'store'])->middleware('auth')->name('tahunajaran.store');
Route::put('tahunajaran/{id}', [TahunAjaranController::class, 'update'])->middleware('auth')->name('tahunajaran.update');
Route::delete('tahunajaran/{id}', [TahunAjaranController::class, 'destroy'])->middleware('auth')->name('tahunajaran.destroy');

// Subjects CRUD
// Mata Pelajaran
Route::get('/matapelajaran', [MataPelajaranController::class, 'index'])->middleware('auth')->name('matapelajaran.index');
Route::post('/matapelajaran', [MataPelajaranController::class, 'store'])->middleware('auth')->name('matapelajaran.store');
Route::put('/matapelajaran/{id}', [MataPelajaranController::class, 'update'])->middleware('auth')->name('matapelajaran.update');
Route::delete('/matapelajaran/{id}', [MataPelajaranController::class, 'destroy'])->middleware('auth')->name('matapelajaran.destroy');

// Pendidik CRUD
Route::get('/pendidik', [PendidikController::class, 'index'])->middleware('auth')->name('pendidik.index');
Route::get('/pendidik/{id}', [PendidikController::class, 'show'])->middleware('auth')->name('pendidik.show');
Route::post('/pendidik', [PendidikController::class, 'store'])->middleware('auth')->name('pendidik.store');
Route::put('/pendidik/{id}', [PendidikController::class, 'update'])->middleware('auth')->name('pendidik.update');
Route::delete('/pendidik/{id}', [PendidikController::class, 'destroy'])->middleware('auth')->name('pendidik.destroy');


/*
|--------------------------------------------------------------------------
| Kelompok Halaqah
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

     // Daftar mapel
    Route::get('/nilaiakademik/mapel', [NilaiMapelController::class, 'index'])
        ->name('nilaiakademik.mapel.index');

    // Detail nilai satu mapel
    Route::get('/nilaiakademik/mapel/{id_mapel}', [NilaiMapelController::class, 'show'])
        ->name('nilaiakademik.mapel.show');

    // Halaman assign santri ke mapel
    Route::get('/nilaiakademik/mapel/{id_mapel}/assign', [NilaiMapelController::class, 'assignForm'])
        ->name('nilaiakademik.mapel.assign.form');

    // Proses assign santri
    Route::post('/nilaiakademik/mapel/{id_mapel}/assign', [NilaiMapelController::class, 'assignStore'])
        ->name('nilaiakademik.mapel.assign.store');

    Route::put('/nilaiakademik/mapel/{id}/update-all', [NilaiMapelController::class, 'updateAll'])->name('nilaiakademik.mapel.updateAll');

    // Update nilai
    Route::put('/nilaiakademik/nilai/{id_nilai}', [NilaiMapelController::class, 'update'])
        ->name('nilaiakademik.mapel.update');

    // Hapus nilai
    Route::delete('/nilaiakademik/nilai/{id_nilai}', [NilaiMapelController::class, 'destroy'])
        ->name('nilaiakademik.mapel.destroy');
 
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

// RAPOR SANTRI
// ============================
Route::middleware('auth')->prefix('rapor')->group(function () {
    Route::get('/', [RaporController::class, 'index'])->name('rapor.index');
    Route::get('/cetak/{nis}', [RaporController::class, 'cetak'])->name('rapor.cetak');

     /*
    |--------------------------------------------------------------------------
    | Nilai Kesantrian
    |--------------------------------------------------------------------------
    */
// Route untuk menampilkan daftar (yang sudah Anda miliki)
Route::get('/nilai-kesantrian', [NilaiKesantrianController::class, 'index'])->name('nilaikesantrian.index');

// Route untuk menyimpan data baru (CREATE/STORE) dari modal
Route::post('/nilai-kesantrian', [NilaiKesantrianController::class, 'store'])->name('nilaikesantrian.store');


// Route untuk detail/show (yang sudah Anda miliki)
Route::get('/nilai-kesantrian/{id_matapelajaran}/{id_tahunAjaran}', [NilaiKesantrianController::class, 'show'])->name('nilaikesantrian.show');


// Route untuk massal update (jika sudah didefinisikan di controller)
Route::post('/nilai-kesantrian/update-massal', [NilaiKesantrianController::class, 'updateNilaiMassal'])->name('nilaikesantrian.update.massal');

// Route untuk assign santri (jika sudah didefinisikan di controller)
Route::post('/nilai-kesantrian/assign/{id_matapelajaran}/{id_tahunAjaran}', [NilaiKesantrianController::class, 'assignStore'])->name('nilaikesantrian.assign.store');

Route::delete('/nilai-kesantrian/unassign/{id}', [NilaiKesantrianController::class, 'unassign'])->name('nilaikesantrian.unassign');
});


   
