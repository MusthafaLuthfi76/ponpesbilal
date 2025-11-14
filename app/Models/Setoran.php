<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setoran extends Model
{
    protected $table = 'setoran';
    protected $primaryKey = 'id_setoran';
    
    protected $fillable = [
        'nis',
        'tanggal_setoran',
        'juz',
        'surah',
        'ayat',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tanggal_setoran' => 'date'
    ];

    // Relasi ke Santri
    public function santri()
    {
        return $this->belongsTo(Santri::class, 'nis', 'nis');
    }
}