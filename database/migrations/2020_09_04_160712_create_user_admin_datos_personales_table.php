<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAdminDatosPersonalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_admin_datos_personales', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_admin_id')->references('id')->on('users_admin')->onDelete('cascade');
			$table->foreignId('path_id')->references('id')->on('path_images')->onDelete('cascade');
			$table->string('nombre');
			$table->string('ap_p');
			$table->string('ap_m');
			$table->string('avatar_image')->nullable();
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
        Schema::dropIfExists('user_admin_datos_personales');
    }
}
