<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaDeJuntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sala_juntas', function (Blueprint $table) {
			$table->id();
			$table->foreignId('edificio_id')->references('id')->on('edificios')->onDelete('cascade');
			$table->foreignId('tipo_oficina_id')->default(2)->references('id')->on('cat_tipos_oficina');
			$table->foreignId('size_id')->references('id')->on('cat_size_oficinas');
			$table->foreignId('path_image_id')->references('id')->on('path_images');
			$table->foreignId('tipo_tiempo_id')->references('id')->on('cat_tiempo_renta');
			$table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('size_dimension');
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
		Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('sala_juntas');
    }
}
