<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiKesantrian extends Model
{
    use HasFactory;

    protected $table = 'nilaikesantrian';
    protected $primaryKey = 'id_nilai_kesantrian';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nis',
        'id_matapelajaran',
        'id_tahunAjaran',
        'nilai_akhlak',
        'nilai_ibadah',
        'nilai_kerapian',
        'nilai_kedisiplinan',
        'nilai_kebersihan',
        'nilai_ekstrakulikuler',
        'nilai_buku_pegangan',
    ];

    /**
     * RELASI KE SANTRI
     */
    public function santri()
    {
        return $this->belongsTo(Santri::class, 'nis', 'nis');
    }

    /**
     * RELASI KE MATA PELAJARAN
     */
    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'id_matapelajaran', 'id_matapelajaran');
    }

    /**
     * RELASI KE TAHUN AJARAN
     */
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahunAjaran', 'id_tahunAjaran');
    }
}