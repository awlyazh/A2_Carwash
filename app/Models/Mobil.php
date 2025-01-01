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
        'nama_mobil',
        'id_pelanggan',
        'id_harga',
    ];
    public function harga()
    {
    return $this->belongsTo(Harga::class, 'id_harga', 'id_harga');
    }

    public function pelanggan()
{
    return $this->belongsTo(Pelanggan::class, 'id_pelanggan','id_pelanggan');
}
public function transaksi()
{
    return $this->hasMany(Transaksi::class, 'no_plat_mobil', 'no_plat_mobil');
}

}