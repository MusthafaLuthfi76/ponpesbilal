<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokHalaqah extends Model
{
    use HasFactory;

    protected $table = 'kelompok_halaqah';
    protected $primaryKey = 'id_halaqah';

    protected $fillable = [
        'nama_kelompok',
        'id_pendidik',
    ];

    // Relasi ke tabel pendidik
    public function pendidik()
    {
        return $this->belongsTo(Pendidik::class, 'id_pendidik', 'id_pendidik');
    }
}
