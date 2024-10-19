<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi'; // Nama tabel yang digunakan
    protected $primaryKey = 'id_transaksi'; // Primary key, auto-increment
    public $incrementing = true; // Pastikan auto-increment aktif
    protected $keyType = 'int'; // Tipe data integer untuk ID

    protected $fillable = [
        'id_akun',
        'no_plat_mobil',
        'metode_pembayaran',
        'total_pembayaran',
        'tanggal_transaksi',
        'status',
    ];
}
