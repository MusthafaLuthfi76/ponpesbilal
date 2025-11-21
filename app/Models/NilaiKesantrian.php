<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiKesantrian extends Model
{
    use HasFactory;

    protected $table = 'nilaikesantrian';
    protected $primaryKey = 'id_nilai_kesantrian';

    // Jika PK bukan auto increment integer, bisa tambahkan:
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
        'nilai_ekstrakulikuler',
        'nilai_buku_pegangan',
    ];

    /**
     * RELASI MODEL
     */

    // Relasi ke tabel Santri (FK: nis → PK: nis)
    public function santri()
    {
        return $this->belongsTo(Santri::class, 'nis', 'nis');
    }

    // Relasi ke Mata Pelajaran
    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'id_matapelajaran', 'id_matapelajaran');
    }

    // Relasi ke Tahun Ajaran
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahunAjaran', 'id_tahunAjaran');
    }
}
