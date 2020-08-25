<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOficinaServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oficina_servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('oficina_id')->references('id')->on('oficinas')->onDelete('cascade');
            $table->foreignId('servicio_id')->references('id')->on('cat_servicios_oficina')->onDelete('cascade');
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
        Schema::dropIfExists('oficina_servicios');
    }
}
