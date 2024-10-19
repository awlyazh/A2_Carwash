<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkunTable extends Migration
{
    public function up()
    {
        Schema::create('akun', function (Blueprint $table) {
            $table->id('id_akun'); // Auto Increment Primary Key
            $table->string('username', 50)->unique(); // Username dengan max length 50
            $table->string('password', 255); // Password yang dienkripsi, panjang max 255
            $table->string('email', 100)->unique(); // Email yang unik dengan panjang max 100
            $table->enum('posisi', ['admin', 'karyawan']); // Posisi (role) bisa admin atau karyawan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('akun');
    }
}
