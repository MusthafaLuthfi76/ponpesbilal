<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiAkademik extends Model
{
    use HasFactory;

    // Nama tabel (karena tidak mengikuti konvensi jamak Laravel)
    protected $table = 'nilaiakademik';

    // Primary key kustom
    protected $primaryKey = 'id_nilai_akademik';

    // Laravel akan otomatis menambah created_at & updated_at
    public $timestamps = true;

    // Kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'nis',
        'id_matapelajaran',
        'id_tahunAjaran',
        'nilai_UTS',
        'nilai_UAS',
        'nilai_praktik',
        'nilai_rata_rata',
        'predikat',
        'keterangan',
        // Kolom baru untuk absensi UTS
        'izin_uts',
        'sakit_uts',
        'ghaib_uts',
        // Kolom baru untuk absensi UAS
        'izin_uas',
        'sakit_uas',
        'ghaib_uas',
    ];

    // ============================
    // 🔗 RELASI ANTAR MODEL
    // ============================

    // Relasi ke Santri (setiap nilai dimiliki satu santri)
    public function santri()
    {
        return $this->belongsTo(Santri::class, 'nis', 'nis');
    }

    // Relasi ke MataPelajaran
    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'id_matapelajaran', 'id_matapelajaran');
    }

    // Relasi ke TahunAjaran
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahunAjaran', 'id_tahunAjaran');
    }

    // ============================
    // ⚡ ACCESSOR/MUTATOR
    // ============================

    /**
     * Hitung total izin (UTS + UAS)
     */
    public function getTotalIzinAttribute()
    {
        return ($this->izin_uts ?? 0) + ($this->izin_uas ?? 0);
    }

    /**
     * Hitung total sakit (UTS + UAS)
     */
    public function getTotalSakitAttribute()
    {
        return ($this->sakit_uts ?? 0) + ($this->sakit_uas ?? 0);
    }

    /**
     * Hitung total ghaib (UTS + UAS)
     */
    public function getTotalGhaibAttribute()
    {
        return ($this->ghaib_uts ?? 0) + ($this->ghaib_uas ?? 0);
    }

    /**
     * Hitung total absensi (semua jenis)
     */
    public function getTotalAbsensiAttribute()
    {
        return $this->total_izin + $this->total_sakit + $this->total_ghaib;
    }
}
