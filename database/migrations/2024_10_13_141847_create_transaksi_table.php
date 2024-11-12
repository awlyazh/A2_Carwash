<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->date('tanggal_transaksi');
            $table->enum('metode_pembayaran', ['cash', 'transfer bank', 'qris']); // Enum untuk metode pembayaran
            $table->double('total_pembayaran');
            $table->enum('status', ['selesai', 'dibatalkan']); // Enum untuk status transaksi
            $table->string('no_plat_mobil'); // Foreign Key ke tabel mobil
            $table->foreign('no_plat_mobil')->references('no_plat_mobil')->on('mobil')->onDelete('cascade');

            // Kolom foreign key untuk relasi dengan tabel akun
            $table->unsignedBigInteger('id_akun');
            $table->foreign('id_akun')->references('id_akun')->on('akun')->onDelete('cascade');
            
            // Kolom foreign key untuk relasi dengan tabel pelanggan
            $table->unsignedBigInteger('id_pelanggan');
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggan')->onDelete('cascade'); // Relasi ke tabel pelanggan
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
