<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    use HasFactory;

    protected $table = 'akun';
    protected $primaryKey = 'id_akun';

    public $incrementing = true; // Menetapkan kolom id_akun sebagai auto-increment

    protected $fillable = [
        'username',
        'password',
        'email',
        'posisi',
    ];

    protected $hidden = [
        'password',
    ];
    public $timestamps = true; // Mengaktifkan timestamps jika Anda ingin menggunakan created_at dan updated_at
}
