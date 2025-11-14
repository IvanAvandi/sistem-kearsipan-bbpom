<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkTerkaitsTable extends Migration
{
    public function up()
    {
        Schema::create('link_terkaits', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('link_url');
            $table->string('lokasi')->default('Portal Awal');
            $table->string('path_icon')->nullable();
            $table->enum('status', ['Aktif', 'NonAktif'])->default('Aktif');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('link_terkaits');
    }
}