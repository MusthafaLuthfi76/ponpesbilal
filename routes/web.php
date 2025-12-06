<?php

use App\Http\Controllers\ProgressController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\PendidikController;
use App\Http\Controllers\HalaqahController;
use App\Http\Controllers\NilaiMapelController;
use App\Http\Controllers\SetoranController;
use App\Http\Controllers\NilaiTahfidzController;
use App\Http\Controllers\RaporController;
use App\Http\Controllers\NilaiKesantrianController;
use App\Http\Controllers\TahunAjaranController;

/*
|--------------------------------------------------------------------------
| PUBLIC PAGE (Landing Page)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing.index');   // halaman landing page
})->name('landing');

Route::get('/progress', [ProgressController::class, 'index'])->name('progress.index');
Route::get('/progress/search', [ProgressController::class, 'search'])->name('progress.search');
Route::get('/progress/{nis}', [ProgressController::class, 'show'])->name('progress.show');


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/admin', [AuthController::class, 'showLogin'])->name('login');
Route::post('/admin', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| ADMIN AREA (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | CRUD Santri
    |--------------------------------------------------------------------------
    */
    Route::get('/santri', [SantriController::class, 'index'])->name('santri.index');
    Route::get('/santri/create', [SantriController::class, 'create'])->name('santri.createSantri');
    Route::post('/santri', [SantriController::class, 'store'])->name('santri.store');
    Route::get('/santri/{id}/edit', [SantriController::class, 'edit'])->name('santri.editSantri');
    Route::put('/santri/{id}', [SantriController::class, 'update'])->name('santri.update');
    Route::put('/santri/{nis}/update-tahunajaran', [SantriController::class, 'updateTahunAjaran'])->name('santri.updateTahunAjaran');
    Route::delete('/santri/{id}', [SantriController::class, 'destroy'])->name('santri.destroy');

    /*
    |--------------------------------------------------------------------------
    | Tahun Ajaran
    |--------------------------------------------------------------------------
    */
    Route::get('/tahunajaran', [TahunAjaranController::class, 'index'])->name('tahunajaran.index');
    Route::post('/tahunajaran', [TahunAjaranController::class, 'store'])->name('tahunajaran.store');
    Route::put('/tahunajaran/{id}', [TahunAjaranController::class, 'update'])->name('tahunajaran.update');
    Route::delete('/tahunajaran/{id}', [TahunAjaranController::class, 'destroy'])->name('tahunajaran.destroy');

    /*
    |--------------------------------------------------------------------------
    | Mata Pelajaran
    |--------------------------------------------------------------------------
    */
    Route::get('/matapelajaran', [MataPelajaranController::class, 'index'])->name('matapelajaran.index');
    Route::post('/matapelajaran', [MataPelajaranController::class, 'store'])->name('matapelajaran.store');
    Route::put('/matapelajaran/{id}', [MataPelajaranController::class, 'update'])->name('matapelajaran.update');
    Route::delete('/matapelajaran/{id}', [MataPelajaranController::class, 'destroy'])->name('matapelajaran.destroy');

    /*
    |--------------------------------------------------------------------------
    | Pendidik
    |--------------------------------------------------------------------------
    */
    Route::get('/pendidik', [PendidikController::class, 'index'])->name('pendidik.index');
    Route::get('/pendidik/{id}', [PendidikController::class, 'show'])->name('pendidik.show');
    Route::post('/pendidik', [PendidikController::class, 'store'])->name('pendidik.store');
    Route::put('/pendidik/{id}', [PendidikController::class, 'update'])->name('pendidik.update');
    Route::delete('/pendidik/{id}', [PendidikController::class, 'destroy'])->name('pendidik.destroy');

    /*
    |--------------------------------------------------------------------------
    | Nilai Akademik (Mapel)
    |--------------------------------------------------------------------------
    */
    Route::get('/nilaiakademik/mapel', [NilaiMapelController::class, 'index'])->name('nilaiakademik.mapel.index');
    Route::get('/nilaiakademik/mapel/{id_mapel}', [NilaiMapelController::class, 'show'])->name('nilaiakademik.mapel.show');
    Route::get('/nilaiakademik/mapel/{id_mapel}/assign', [NilaiMapelController::class, 'assignForm'])->name('nilaiakademik.mapel.assign.form');
    Route::post('/nilaiakademik/mapel/{id_mapel}/assign', [NilaiMapelController::class, 'assignStore'])->name('nilaiakademik.mapel.assign.store');
    Route::put('/nilaiakademik/mapel/{id}/update-all', [NilaiMapelController::class, 'updateAll'])->name('nilaiakademik.mapel.updateAll');
    Route::put('/nilaiakademik/nilai/{id_nilai}', [NilaiMapelController::class, 'update'])->name('nilaiakademik.mapel.update');
    Route::delete('/nilaiakademik/nilai/{id_nilai}', [NilaiMapelController::class, 'destroy'])->name('nilaiakademik.mapel.destroy');

    /*
    |--------------------------------------------------------------------------
    | Halaqah
    |--------------------------------------------------------------------------
    */
    Route::get('/halaqah', [HalaqahController::class, 'index'])->name('halaqah.index');
    Route::post('/halaqah', [HalaqahController::class, 'store'])->name('halaqah.store');
    Route::put('/halaqah/{id}', [HalaqahController::class, 'update'])->name('halaqah.update');
    Route::delete('/halaqah/{id}', [HalaqahController::class, 'destroy'])->name('halaqah.destroy');
    Route::get('/halaqah/{id}', [HalaqahController::class, 'show'])->name('halaqah.show');
    Route::delete('/halaqah/{id_halaqah}/remove-santri/{nis}', [HalaqahController::class, 'removeSantri'])->name('halaqah.removeSantri');
    Route::get('/halaqah/{id_halaqah}/add-santri', [HalaqahController::class, 'showAddSantri'])->name('halaqah.showAddSantri');
    Route::post('/halaqah/{id_halaqah}/add-santri', [HalaqahController::class, 'addSantri'])->name('halaqah.addSantri');

    /*
    |--------------------------------------------------------------------------
    | Setoran
    |--------------------------------------------------------------------------
    */
    Route::get('/setoran/{nis}', [SetoranController::class, 'index'])->name('setoran.index');
    Route::post('/setoran/{nis}', [SetoranController::class, 'store'])->name('setoran.store');
    Route::put('/setoran/{nis}/{id_setoran}', [SetoranController::class, 'update'])->name('setoran.update');
    Route::delete('/setoran/{nis}/{id_setoran}', [SetoranController::class, 'destroy'])->name('setoran.destroy');

    /*
    |--------------------------------------------------------------------------
    | Nilai Tahfidz
    |--------------------------------------------------------------------------
    */
    Route::get('/nilaiTahfidz', [NilaiTahfidzController::class, 'index'])->name('nilaiTahfidz.index');
    Route::get('/nilaiTahfidz/ujian-baru', [NilaiTahfidzController::class, 'createUjianBaru'])->name('nilaiTahfidz.createUjianBaru');
    Route::post('/nilaiTahfidz/ujian-baru', [NilaiTahfidzController::class, 'storeUjianBaru'])->name('nilaiTahfidz.storeUjianBaru');
    Route::get('/nilaiTahfidz/{id}/input-nilai', [NilaiTahfidzController::class, 'inputNilai'])->name('nilaiTahfidz.inputNilai');
    Route::post('/nilaiTahfidz/{id}/input-nilai', [NilaiTahfidzController::class, 'storeNilai'])->name('nilaiTahfidz.storeNilai');
    Route::get('/nilaiTahfidz/{id}/detail', [NilaiTahfidzController::class, 'show'])->name('nilaiTahfidz.show');
    Route::post('/nilaiTahfidz', [NilaiTahfidzController::class, 'store'])->name('nilaiTahfidz.store');
    Route::put('/nilaiTahfidz/{id}', [NilaiTahfidzController::class, 'update'])->name('nilaiTahfidz.update');
    Route::delete('/nilaiTahfidz/{id}', [NilaiTahfidzController::class, 'destroy'])->name('nilaiTahfidz.destroy');
    Route::get('/nilai-tahfidz/{nis}/create', [NilaiTahfidzController::class, 'create'])
    ->name('nilaiTahfidz.create');


    /*
    |--------------------------------------------------------------------------
    | Rapor
    |--------------------------------------------------------------------------
    */
    Route::get('/rapor', [RaporController::class, 'index'])->name('rapor.index');
    Route::get('/rapor/cetak/{nis}', [RaporController::class, 'cetak'])->name('rapor.cetak');
    /*
    |--------------------------------------------------------------------------
    | Rapor
    |--------------------------------------------------------------------------
    */
    Route::get('/rapor', [RaporController::class, 'index'])->name('rapor.index');
    Route::get('/rapor/cetak/{nis}', [RaporController::class, 'cetak'])->name('rapor.cetak');
    Route::post('/rapor/cetak-bulk', [RaporController::class, 'cetakBulk'])->name('rapor.cetak.bulk');  

    /*
    |--------------------------------------------------------------------------
    | Nilai Kesantrian
    |--------------------------------------------------------------------------
    */
    Route::get('/nilai-kesantrian', [NilaiKesantrianController::class, 'index'])->name('nilaikesantrian.index');
    Route::post('/nilai-kesantrian', [NilaiKesantrianController::class, 'store'])->name('nilaikesantrian.store');
    Route::get('/nilai-kesantrian/{id_matapelajaran}/{id_tahunAjaran}', [NilaiKesantrianController::class, 'show'])->name('nilaikesantrian.show');
    Route::post('/nilai-kesantrian/update-massal', [NilaiKesantrianController::class, 'updateNilaiMassal'])->name('nilaikesantrian.update.massal');
    Route::post('/nilai-kesantrian/assign/{id_matapelajaran}/{id_tahunAjaran}', [NilaiKesantrianController::class, 'assignStore'])->name('nilaikesantrian.assign.store');
    Route::delete('/nilai-kesantrian/unassign/{id}', [NilaiKesantrianController::class, 'unassign'])->name('nilaikesantrian.unassign');

});