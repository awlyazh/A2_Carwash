<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHargaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harga', function (Blueprint $table) {
            $table->id('id_harga');                         // Primary Key
            $table->string('jenis_mobil', 50)->unique();    // Jenis mobil, unik
            $table->decimal('harga', 10, 3)->default(0.000); // Harga untuk jenis mobil tersebut, default 0.00
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Menghapus tabel harga
        Schema::dropIfExists('harga');
    }
}
