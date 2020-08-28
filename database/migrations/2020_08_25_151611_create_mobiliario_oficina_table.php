<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobiliarioOficinaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobiliario_oficina_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('oficina_id')->references('id')->on('oficinas')->onDelete('cascade');
            $table->foreignId('mobiliario_id')->references('id')->on('mobiliarios')->onDelete('cascade');
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
        Schema::dropIfExists('mobiliario_oficina_table');
    }
}