<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArsipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arsip', function (Blueprint $table) {
            $table->id();
            
            // --- Kunci Relasi (Foreign Keys) ---

            /**
             * Mencegah penghapusan Klasifikasi jika masih digunakan oleh Arsip.
             * (Sesuai Skenario 1 - Proteksi Data)
             */
            $table->foreignId('klasifikasi_surat_id')
                  ->constrained('klasifikasi_surat')
                  ->onDelete('restrict');

            /**
             * Mencegah penghapusan Divisi jika masih digunakan oleh Arsip.
             * (Sesuai Skenario 1 - Proteksi Data)
             */
            $table->foreignId('divisi_id')
                  ->constrained('divisi')
                  ->onDelete('restrict'); 
            
            /**
             * Jika Bentuk Naskah dihapus, jadikan NULL (non-kritis).
             */
            $table->foreignId('bentuk_naskah_id')
                  ->nullable()
                  ->constrained('bentuk_naskahs')
                  ->onDelete('set null');

            /**
             * Mencegah penghapusan User jika masih memiliki Arsip.
             * (Sesuai Skenario 1 - Proteksi Data)
             */
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->onDelete('restrict'); 

            // --- Detail Arsip ---
            $table->text('uraian_berkas');
            $table->date('tanggal_arsip');
            $table->string('kurun_waktu')->nullable();
            $table->string('jumlah_berkas')->nullable();
            $table->string('tingkat_perkembangan');
            $table->string('lokasi_penyimpanan');
            $table->text('keterangan_fisik')->nullable();
            $table->text('link_eksternal')->nullable();
            $table->string('status', 50)->default('Aktif');

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
        Schema::dropIfExists('arsip');
    }
}