<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['nama_karyawan', 'no_hp', 'jumlah_mobil_dicuci', 'jumlah_uang_dihasilkan'];

    // Relasi dengan Transaksi (Karyawan memiliki banyak transaksi)
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_karyawan', 'id_karyawan');
    }
}
