<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplatesTable extends Migration
{
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('nama_template');
            $table->text('deskripsi')->nullable();
            $table->string('kategori');
            $table->string('nama_file');
            $table->string('file_path');
            
            // JANGAN hapus template jika User (Creator) dihapus
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->onDelete('restrict'); 
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('templates');
    }
}