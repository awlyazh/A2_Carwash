<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan'; // Nama tabel
    protected $primaryKey = 'id_pelanggan'; // Primary key
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_pelanggan',
        'no_hp',
        'nama',
    ];

    // Relasi ke model Mobil
    public function mobil()
    {
        return $this->hasMany(Mobil::class, 'id_pelanggan', 'id_pelanggan');
    }

    /**
     * Fungsi untuk mengambil daftar no plat mobil berdasarkan ID pelanggan.
     *
     * @return array
     */
    public function getNoPlatMobil()
    {
        return $this->mobil()->pluck('no_plat_mobil')->toArray();
    }
}
