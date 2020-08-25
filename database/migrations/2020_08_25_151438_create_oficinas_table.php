<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOficinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oficinas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('edificio_id')->references('id')->on('edificios')->onDelete('cascade');
            $table->foreignId('tipo_oficina_id')->references('id')->on('cat_tipos_oficina');
            $table->foreignId('tipo_oficina_virtual')->references('id')->on('cat_tipo_oficina_virtual')->nullable();
            $table->foreignId('size_id')->references('id')->on('cat_size_oficinas');
            $table->string('nombre');
            $table->longText('descripcion');
            $table->string('size');
            $table->smallInteger('capacidad_recomendada');
            $table->smallInteger('capacidad_maxima');
            $table->double('precio', 10, 4);
            $table->boolean('en_uso')->default(false);
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
        Schema::dropIfExists('oficinas');
    }
}
