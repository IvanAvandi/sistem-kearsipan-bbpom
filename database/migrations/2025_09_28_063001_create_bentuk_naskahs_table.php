<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBentukNaskahsTable extends Migration
{
    public function up()
    {
        Schema::create('bentuk_naskahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bentuk_naskah')->unique();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('bentuk_naskahs');
    }
}