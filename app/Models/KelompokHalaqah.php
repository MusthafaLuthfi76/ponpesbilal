<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokHalaqah extends Model
{
    use HasFactory;
    protected $table = 'kelompok_halaqah';
    protected $primaryKey = 'id_halaqah';
}
