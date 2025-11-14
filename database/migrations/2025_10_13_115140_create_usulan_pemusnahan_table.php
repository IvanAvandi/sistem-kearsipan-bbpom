<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsulanPemusnahanTable extends Migration
{
    public function up()
    {
        Schema::create('usulan_pemusnahan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_usulan')->unique();
            $table->date('tanggal_usulan');
            $table->string('status', 50)->default('Draft');

            // JANGAN hapus usulan jika User (Creator) dihapus
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->onDelete('restrict'); 

            // Kolom Surat Usulan (Draft)
            $table->string('nomor_surat_usulan')->nullable();
            $table->date('tanggal_surat_usulan')->nullable();
            $table->string('file_surat_usulan_path')->nullable();

            // Kolom Persetujuan Pusat
            $table->string('nomor_surat_persetujuan')->nullable();
            $table->date('tanggal_surat_persetujuan')->nullable();
            $table->string('file_surat_persetujuan_path')->nullable();
            $table->date('tanggal_pemusnahan_fisik')->nullable();

            // Kolom Berita Acara Final
            $table->string('nomor_bapa_diterima')->nullable();
            $table->date('tanggal_bapa_diterima')->nullable();
            $table->string('file_bapa_diterima_path')->nullable();

            // Kolom Penolakan Pusat
            $table->string('nomor_surat_penolakan')->nullable();
            $table->date('tanggal_surat_penolakan')->nullable();
            $table->string('file_surat_penolakan_path')->nullable();
            $table->text('catatan_penolakan')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usulan_pemusnahan');
    }
}