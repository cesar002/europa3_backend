<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsumosUsadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumos_usados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insumo_comprado_id')->references('id')->on('insumos_comprados');
            $table->foreignId('user_admin_id')->references('id')->on('users_admin');
            $table->integer('cantidad_usada');
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
        Schema::dropIfExists('insumos_usados');
    }
}
