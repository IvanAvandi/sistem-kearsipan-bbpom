<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUraianIsiInformasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uraian_isi_informasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('arsip_id')->constrained('arsip')->onDelete('cascade');
            
            // Kolom dari add_item_fields...
            $table->string('nomor_item')->nullable();
            
            // Kolom asli
            $table->text('uraian');

            // Kolom dari add_item_fields...
            $table->date('tanggal')->nullable();
            
            // Kolom asli
            $table->string('jumlah_lembar');
            
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
        Schema::dropIfExists('uraian_isi_informasi');
    }
}