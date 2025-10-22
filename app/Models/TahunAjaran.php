<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $table = 'tahunajaran';
    protected $primaryKey = 'id_tahunAjaran'; // ini penting
    protected $fillable = ['tahun','semester'];
    public $incrementing = true; // jika kolom id_tahunAjaran auto increment
}
