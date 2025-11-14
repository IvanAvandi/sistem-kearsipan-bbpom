<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKlasifikasiSuratTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('klasifikasi_surat', function (Blueprint $table) {
            $table->id();
            $table->string('kode_klasifikasi')->unique();
            $table->text('nama_klasifikasi');
            $table->integer('masa_aktif'); // dalam tahun
            $table->integer('masa_inaktif'); // dalam tahun
            $table->enum('status_akhir', ['Musnah', 'Permanen']);
            
            $table->enum('klasifikasi_keamanan', [
                'Biasa/Terbuka',
                'Terbatas',
                'Rahasia',
                'Sangat Rahasia'
            ]);
            
            $table->string('hak_akses')->nullable();
            
            $table->string('unit_pengolah')->nullable();
            
            $table->timestamps();
            
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('klasifikasi_surat');
    }
}