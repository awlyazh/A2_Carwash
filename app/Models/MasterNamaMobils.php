<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterNamaMobils extends Model
{
    use HasFactory;
    protected $table = 'masternamamobils'; // Nama tabel
    protected $fillable = ['nama_mobil']; 

    public function mobil()
    {
        return $this->hasMany(Mobil::class, 'nama_mobil', 'nama_mobil');
    }
}
