<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendasUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendas_users', function (Blueprint $table) {
            $table->id();
			$table->foreignId('user_id')->references('id')->on('users');
			$table->date('fecha_actividad');
			$table->time('hora_inicio')->nullable();
			$table->time('hora_fin')->nullable();
			$table->string('titulo');
			$table->text('contenido')->nullable();
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
        Schema::dropIfExists('agendas_users');
    }
}
