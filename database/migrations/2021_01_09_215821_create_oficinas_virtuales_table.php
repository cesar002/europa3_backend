<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOficinasVirtualesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oficinas_virtuales', function (Blueprint $table) {
			$table->id();
			$table->foreignId('edificio_id')->references('id')->on('edificios')->onDelete('cascade');
			$table->foreignId('tipo_oficina_id')->references('id')->on('cat_tipos_oficina');
			$table->foreignId('tipo_tiempo_id')->references('id')->on('cat_tiempo_renta');
			$table->string('nombre');
			$table->longText('descripcion')->nullable();
			$table->double('precio', 10, 4);
			$table->boolean('en_uso')->default(false);
			$table->softDeletes();
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
        Schema::dropIfExists('oficinas_virtuales');
    }
}
