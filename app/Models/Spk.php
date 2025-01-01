<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spk extends Model
{
    use HasFactory;

    protected $table = 'spk';
    protected $fillable = [
        'id_karyawan',
        'jumlah_mobil_dicuci',
        'jumlah_uang_dihasilkan',
        'skor',
        'peringkat',
        'tanggal_periode_start',
        'tanggal_periode_end',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
}
