<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersAdminPermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_admin_permisos', function (Blueprint $table) {
            $table->id();
			$table->foreignId('user_admin_id')->references('id')->on('users_admin')->onDelete('cascade');
			$table->foreignId('permiso_id')->references('id')->on('cat_permisos_modulos');
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
        Schema::dropIfExists('users_admin_permisos');
    }
}
