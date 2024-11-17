<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_pelanggan',
        'no_plat_mobil',
        'tanggal_transaksi',
        'metode_pembayaran',
        'total_pembayaran',
        'status',
        'id_akun',
        'id_karyawan',
        'jumlah_mobil_dicuci',
        'jumlah_uang_dihasilkan',
    ];

    // Relasi dengan pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    // Relasi dengan mobil
    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'no_plat_mobil', 'no_plat_mobil');
    }

    // Relasi dengan karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }
}
