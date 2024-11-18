<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan'; // Nama tabel yang digunakan
    protected $primaryKey = 'id_pelanggan'; // Primary key
    public $incrementing = true; // Pastikan auto-increment aktif
    protected $keyType = 'int'; // Tipe data integer untuk ID

    protected $fillable = [
        'id_pelanggan',
        'no_hp',
        'nama',
    ];

    // Relasi ke model Mobil
    public function mobil()
{
    return $this->hasOne(Mobil::class, 'id_pelanggan');
}

}
