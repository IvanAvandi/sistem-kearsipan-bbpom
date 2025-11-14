<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArsipFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arsip_files', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke tabel 'arsip'
            // onDelete('cascade') berarti jika arsip dihapus, file-filenya ikut terhapus
            $table->foreignId('arsip_id')->constrained('arsip')->onDelete('cascade');
            
            $table->string('path_file'); // Path penyimpanan di storage
            $table->string('nama_file_original'); // Nama asli file (mis: "laporan.pdf")
            $table->unsignedBigInteger('size')->nullable(); // Ukuran file dalam bytes
            
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
        Schema::dropIfExists('arsip_files');
    }
}