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
        'id_tahunAjaran',
        // Kolom UTS
        'akhlak_uts',
        'ibadah_uts',
        'kerapian_uts',
        'kedisiplinan_uts',
        'ekstrakulikuler_uts',
        'buku_pegangan_uts',
        // Kolom UAS
        'akhlak_uas',
        'ibadah_uas',
        'kerapian_uas',
        'kedisiplinan_uas',
        'ekstrakulikuler_uas',
        'buku_pegangan_uas',
    ];

    /**
     * RELASI KE SANTRI
     */
    public function santri()
    {
        return $this->belongsTo(Santri::class, 'nis', 'nis');
    }

    /**
     * RELASI KE TAHUN AJARAN
     */
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahunAjaran', 'id_tahunAjaran');
    }
}
