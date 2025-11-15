<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UjianTahfidz extends Model
{
    use HasFactory;

    protected $table = 'ujian_tahfidz'; // sesuaikan dengan nama tabel Anda

    protected $fillable = [
        'nis',
        'juz',
        'tajwid',
        'itqan',
        'total_kesalahan',
        'jenis_ujian', // UTS atau UAS
        'tahun_ajaran_id',
        'sekali_duduk',
    ];

    /**
     * Relasi ke Santri
     */
    public function santri()
    {
        return $this->belongsTo(Santri::class, 'santri_id');
    }

    /**
     * Relasi ke Tahun Ajaran (jika diperlukan)
     */
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahunAjaran', 'id_tahunAjaran');

    }

    /**
     * Boot method untuk auto calculate total_kesalahan
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($ujian) {
            $ujian->total_kesalahan = $ujian->tajwid + $ujian->itqan;
        });
    }
}