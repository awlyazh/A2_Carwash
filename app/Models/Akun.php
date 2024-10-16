<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    use HasFactory;
    protected $table = 'akun'; // Nama tabel yang digunakan
    protected $primaryKey = 'id_akun'; // Primary key, auto-increment
    public $incrementing = true; // Pastikan auto-increment aktif
    protected $keyType = 'int'; // Tipe data integer untuk ID

    protected $fillable = [
        'id_akun',
        'username',
        'password',
        'email',
        'posisi',
    ];

    protected $hidden = [
        'password',
    ];

    public $timestamps = true; // Mengaktifkan timestamps jika Anda ingin menggunakan created_at dan updated_at
}
