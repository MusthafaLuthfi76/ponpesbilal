<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;

    protected $table = 'santri';
    protected $primaryKey = 'id_santri';
    protected $fillable = [
        'nama',
        'angkatan',
        'status',
        'id_tahunAjaran',
        'id_orangtua',
    ];
}
