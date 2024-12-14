<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spk', function (Blueprint $table) {
            $table->id('id_spk'); // Primary Key
            $table->unsignedBigInteger('id_karyawan'); // Foreign Key ke tabel Karyawan
            $table->integer('jumlah_mobil_dicuci')->default(0); // Jumlah mobil dicuci
            $table->decimal('jumlah_uang_dihasilkan', 10, 2)->default(0.00); // Jumlah uang dihasilkan
            $table->decimal('skor', 5, 3)->default(0.000); // Skor hasil SPK
            $table->integer('peringkat')->default(0); // Peringkat berdasarkan skor
            $table->date('tanggal_periode_start'); // Periode awal
            $table->date('tanggal_periode_end'); // Periode akhir
            $table->timestamps();

            // Relasi dengan tabel Karyawan
            $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spk');
    }
}
