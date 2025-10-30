<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    // Nama tabel yang digunakan
    protected $table = 'matapelajaran';

    // Primary key custom
    protected $primaryKey = 'id_matapelajaran';

    // Tidak auto-increment (karena di migration tidak pakai increments)
    public $incrementing = false;

    // Jenis primary key (unsignedBigInteger)
    protected $keyType = 'int';

    // Kolom yang bisa diisi mass-assignment
    protected $fillable = [
        'id_matapelajaran',
        'nama_matapelajaran',
        'kkm',
        'bobot_UTS',
        'bobot_UAS',
        'bobot_praktik',
        'id_pendidik',
        'id_tahunAjaran'
    ];

    // Relasi ke tabel pendidik
    public function pendidik()
    {
        return $this->belongsTo(Pendidik::class, 'id_pendidik', 'id_pendidik');
    }

    // Relasi ke tabel tahunajaran
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahunAjaran', 'id_tahunAjaran');
    }
}
