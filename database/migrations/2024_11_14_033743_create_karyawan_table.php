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
            $table->id('id_karyawan');                   // Primary Key
            $table->string('nama_karyawan', 100);        // Nama karyawan
            $table->string('no_hp', 15)->nullable();     // Nomor HP karyawan, nullable
            $table->string('no_plat_mobil', 20)->nullable(); // No plat mobil terkait, nullable
            $table->timestamps();

            // Menambahkan constraint foreign key jika no_plat_mobil berelasi dengan tabel mobil
            $table->foreign('no_plat_mobil')
                  ->references('no_plat_mobil')
                  ->on('mobil')
                  ->onUpdate('cascade')
                  ->onDelete('set null'); // Set null jika mobil dihapus
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('karyawan', function (Blueprint $table) {
            // Menghapus foreign key sebelum drop tabel
            $table->dropForeign(['no_plat_mobil']);
        });
        
        Schema::dropIfExists('karyawan');
    }
}
