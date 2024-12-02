<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id('id_karyawan');                     // Primary Key
            $table->string('nama_karyawan', 100);          // Nama karyawan
            $table->string('no_hp', 15);                   // Nomor HP
            $table->integer('jumlah_mobil_dicuci')->default(0); // Jumlah mobil dicuci (default 0)
            $table->decimal('jumlah_uang_dihasilkan', 10, 2)->default(0.00); // Jumlah uang dihasilkan (default 0.00)
            $table->timestamps();                          // Timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('karyawan');
    }
}
