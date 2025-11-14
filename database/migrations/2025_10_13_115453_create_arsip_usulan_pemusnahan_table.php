<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArsipUsulanPemusnahanTable extends Migration
{
    public function up()
    {
        Schema::create('arsip_usulan_pemusnahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('arsip_id')->constrained('arsip')->onDelete('cascade');
            $table->foreignId('usulan_pemusnahan_id')->constrained('usulan_pemusnahan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('arsip_usulan_pemusnahan');
    }
}