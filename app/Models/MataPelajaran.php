<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'matapelajaran';
    protected $primaryKey = 'id_matapelajaran';

    // id_matapelajaran dari migration sudah auto increment
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_matapelajaran',
        'kelas',
        'materi_pelajaran',
        'kkm',
        'bobot_UTS',
        'bobot_UAS',
        'bobot_praktik',
        'id_pendidik',
        'id_tahunAjaran'
    ];

    public function pendidik()
    {
        return $this->belongsTo(Pendidik::class, 'id_pendidik', 'id_pendidik');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahunAjaran', 'id_tahunAjaran');
    }
}
