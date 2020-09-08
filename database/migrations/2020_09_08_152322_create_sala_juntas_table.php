<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaJuntasTable extends Migration
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
			$table->foreignId('edificio_id')->references('id')->on('edificios')->onDetele('cascade');
			$table->foreignId('tipo_id')->references('id')->on('cat_tipos_oficina')->onDelete('cascade');
			$table->foreignId('size_id')->references('id')->on('cat_size_oficinas');
			$table->string('nombre');
			$table->text('descripcion');
			$table->mediumInteger('capacidad_max');
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
        Schema::dropIfExists('sala_juntas');
    }
}
