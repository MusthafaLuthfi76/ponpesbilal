<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UjianTahfidz extends Model
{
    use HasFactory;

    protected $table = 'ujian_tahfidz';

    protected $fillable = [
        'nis',
        'juz',
        'tajwid',
        'itqan',
        'total_kesalahan',
        'jenis_ujian', // UTS atau UAS
        'id_tahunAjaran', // ✅ Ganti dari tahun_ajaran_id ke id_tahunAjaran
        'sekali_duduk',
    ];

    /**
     * Relasi ke Santri
     */
    public function santri()
    {
        return $this->belongsTo(Santri::class, 'nis', 'nis');
    }

    /**
     * Relasi ke Tahun Ajaran
     */
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahunAjaran', 'id_tahunAjaran');
    }

    /**
     * Nilai angka otomatis (1–100)
     * Setiap 1 kesalahan = dikurangi 1 poin
     */
    public function getNilaiAngkaAttribute()
    {
        // ✅ PERBAIKAN: setiap 1 kesalahan = -1 poin (bukan -5)
        return max(0, 100 - $this->total_kesalahan);
    }

    /**
     * Nilai huruf otomatis berdasarkan nilai angka
     */
    public function getNilaiHurufAttribute()
    {
        $angka = $this->nilai_angka;

        if ($angka >= 90) return 'A';
        if ($angka >= 80) return 'B';
        if ($angka >= 70) return 'C';
        return 'D';
    }

    /**
     * Boot method untuk auto calculate total_kesalahan
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($ujian) {
            // ✅ Otomatis hitung total kesalahan saat save
            $ujian->total_kesalahan = $ujian->tajwid + $ujian->itqan;
        });
    }
}