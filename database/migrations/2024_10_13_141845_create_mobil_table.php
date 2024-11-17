<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobilTable extends Migration
{
    public function up()
    {
        Schema::create('mobil', function (Blueprint $table) {
            $table->string('no_plat_mobil', 20);
            $table->primary('no_plat_mobil');
            $table->string('nama_mobil', 100); // Nama mobil dengan max length 100
            $table->string('jenis_mobil', 50);
            $table->unsignedBigInteger('id_pelanggan');
            $table->unsignedBigInteger('id_harga');
            $table->timestamps();

            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggan')->onDelete('cascade');
            $table->foreign('id_harga')->references('id_harga')->on('harga')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mobil');
    }
}
