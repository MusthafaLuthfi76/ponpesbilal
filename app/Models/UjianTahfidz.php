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
        'tahun_ajaran_id',
        'sekali_duduk',
        'id_penguji',
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
        // Using tahun_ajaran_id from migration
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id', 'id_tahunAjaran');
    }

    /**
     * Relasi ke Penguji (Pendidik)
     */
    public function penguji()
    {
        return $this->belongsTo(Pendidik::class, 'id_penguji', 'id_pendidik');
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
            // ✅ Otomatis hitung total kesalahan saat save (handle nullable)
            $tajwid = $ujian->tajwid ?? 0;
            $itqan = $ujian->itqan ?? 0;
            $ujian->total_kesalahan = $tajwid + $itqan;
        });
    }
}