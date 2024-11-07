<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;

    protected $table = 'mobil'; // Nama tabel yang digunakan
    protected $primaryKey = 'no_plat_mobil'; // Primary key, auto-increment
    public $incrementing = false; // Pastikan auto-increment aktif
    protected $keyType = 'string';

    protected $fillable = [
        'no_plat_mobil',
        'id_pelanggan',
        'jenis_mobil',
        'nama_mobil',
    ];
}
