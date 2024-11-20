<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    use HasFactory;

    protected $table = 'harga'; // Nama tabel
    protected $primaryKey = 'id_harga'; // Primary key
    public $timestamps = true; // Timestamps aktif

    // Kolom yang bisa diisi (mass assignable)
    protected $fillable = ['jenis_mobil', 'harga'];

    public function mobil()
    {
        return $this->hasMany(Mobil::class, 'id_harga', 'id_harga');
    }
}