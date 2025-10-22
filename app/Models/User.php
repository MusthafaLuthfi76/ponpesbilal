<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Nama tabel di database
     */
    protected $table = 'user';

    /**
     * Primary key tabel
     */
    protected $primaryKey = 'id_user';

    /**
     * Tidak menggunakan timestamps karena migration kamu tidak menambahkannya
     */
    public $timestamps = false;

    /**
     * Kolom yang bisa diisi secara massal
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
    ];

    /**
     * Kolom yang disembunyikan saat serialisasi
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Casting atribut tertentu
     */
    protected $casts = [
        'password' => 'hashed',
    ];
}
