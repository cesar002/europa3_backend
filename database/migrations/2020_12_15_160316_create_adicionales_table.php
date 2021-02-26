<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdicionalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adicionales', function (Blueprint $table) {
			$table->id();
			$table->bigInteger('edificio_id')->nullable(false);
			$table->bigInteger('unidad_id')->nullable(false);
			$table->string('nombre')->nullable(false);
			$table->text('descripcion')->nullable();
			$table->integer('unidad_base')->nullable(false);
			$table->integer('cantidad_maxima')->nullable(false);
			$table->double('precio', 10, 4)->nullable(false);
			$table->boolean('disponible')->default(true);
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
        Schema::dropIfExists('adicionales');
    }
}
