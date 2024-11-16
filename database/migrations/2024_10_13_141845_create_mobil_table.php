<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobilTable extends Migration
{
    public function up()
    {
        Schema::create('mobil', function (Blueprint $table) {
            $table->string('no_plat_mobil', 20); // No Plat Mobil, tidak perlu primary key di sini
            $table->string('nama_mobil', 100); // Nama Mobil
            $table->string('jenis_mobil', 50); // Jenis Mobil
            $table->unsignedBigInteger('id_pelanggan'); // Foreign Key ke pelanggan
            $table->unsignedBigInteger('id_harga'); // Foreign Key ke harga
            $table->timestamps();
        
            // Foreign Key untuk relasi dengan tabel pelanggan
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggan')->onDelete('cascade');
        
            // Pastikan kombinasi no_plat_mobil dan id_harga unik
            $table->unique(['no_plat_mobil', 'id_harga']);
        });        
    }

    public function down()
    {
        Schema::dropIfExists('mobil');
    }
}
