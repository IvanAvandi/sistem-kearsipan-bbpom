<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsulanPindahsTable extends Migration
{
    public function up()
    {
        Schema::create('usulan_pindahs', function (Blueprint $table) {
            $table->id();
            
            // DIBUAT OLEH (Arsiparis Pembuat Draft)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('restrict'); 
            
            $table->string('status')->default('Draft');
            
            // Info Berita Acara (BA)
            $table->string('nomor_ba')->nullable();
            $table->date('tanggal_ba')->nullable();
            $table->string('file_ba_path')->nullable();
            
            // --- AUDIT TRAIL ---
            $table->foreignId('diusulkan_oleh_id')->nullable()->constrained('users')->onDelete('restrict');
            $table->timestamp('diajukan_pada')->nullable(); 

            $table->foreignId('dikembalikan_oleh_id')->nullable()->constrained('users')->onDelete('restrict'); 
            $table->timestamp('dikembalikan_pada')->nullable();
            $table->text('catatan_admin')->nullable();

            $table->foreignId('disetujui_oleh_id')->nullable()->constrained('users')->onDelete('restrict'); 
            $table->timestamp('disetujui_pada')->nullable();

            $table->foreignId('dibatalkan_oleh_id')->nullable()->constrained('users')->onDelete('restrict'); 
            $table->timestamp('dibatalkan_pada')->nullable();
            
            $table->timestamps();
        });

        // Tabel pivot (Ini sudah benar menggunakan cascade)
        Schema::create('arsip_usulan_pindah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usulan_pindah_id')->constrained('usulan_pindahs')->onDelete('cascade');
            $table->foreignId('arsip_id')->constrained('arsip')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('arsip_usulan_pindah');
        Schema::dropIfExists('usulan_pindahs');
    }
}