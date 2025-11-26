<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;

    protected $table = 'santri';
    protected $primaryKey = 'nis'; // ✅ sesuai migration
    public $incrementing = false; // karena bukan auto increment
    protected $keyType = 'string'; // tipe primary key string

    protected $fillable = [
        'nis',
        'nama',
        'angkatan',
        'status',
        'id_tahunAjaran',
        'id_halaqah',
    ];

    // Tambahkan relasi ini 👇
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahunAjaran', 'id_tahunAjaran');
    }
    public function halaqah()
    {
    return $this->belongsTo(KelompokHalaqah::class, 'id_halaqah', 'id_halaqah');
    }
    public function ujianTahfidz()
    {
    return $this->hasMany(\App\Models\UjianTahfidz::class, 'nis', 'nis');
    }
    public function nilaiKesantrian()
    {
        return $this->hasMany(\App\Models\NilaiKesantrian::class, 'nis', 'nis');
    }
}
