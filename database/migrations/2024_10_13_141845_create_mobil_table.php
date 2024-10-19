<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobilTable extends Migration
{
    public function up()
    {
        Schema::create('mobil', function (Blueprint $table) {
            $table->string('no_plat_mobil', 20)->primary(); // Primary Key dan panjang maksimal 10 karakter
            $table->string('nama_mobil', 100); // Nama mobil dengan max length 100
            $table->string('jenis_mobil', 50); // Jenis mobil dengan max length 50
            $table->unsignedBigInteger('id_pelanggan'); // Foreign Key ke tabel pelanggan
            $table->timestamps();

            // Foreign Key Constraint
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mobil');
    }
}
