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
        'jumlah_izin',
        'jumlah_sakit',
        'jumlah_ghaib',
        'nilai_rata_rata',
        'predikat',
        'keterangan',
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
}
