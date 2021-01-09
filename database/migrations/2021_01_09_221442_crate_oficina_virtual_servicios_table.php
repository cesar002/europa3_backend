<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrateOficinaVirtualServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oficina_virtual_servicios', function (Blueprint $table) {
			$table->id();
			$table->foreignId('oficina_virtual_id')->references('id')->on('oficinas_virtuales')->onDelete('cascade');
            $table->foreignId('servicio_id')->references('id')->on('cat_servicios')->onDelete('cascade');
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
        Schema::dropIfExists('oficina_virtual_servicios');
    }
}
