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

            // Perbaikan di sini
            $table->unsignedBigInteger('id_akun'); // Pastikan tipe yang benar
            $table->foreign('id_akun')->references('id_akun')->on('akun')->onDelete('cascade'); // Sesuaikan foreign key
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
