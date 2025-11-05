<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendidik extends Model
{
    use HasFactory;

    protected $table = 'pendidik';
    protected $primaryKey = 'id_pendidik';
    public $incrementing = true; // id auto increment
    protected $keyType = 'int';  // ✅ ubah ke int

    protected $fillable = [
        'nama',
        'jabatan',
        'id_user',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
