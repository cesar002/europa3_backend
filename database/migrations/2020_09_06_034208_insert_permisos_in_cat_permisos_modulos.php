<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertPermisosInCatPermisosModulos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    DB::unprepared("
      INSERT INTO cat_permisos_modulos(nombre, created_at, updated_at) VALUES
        ('Master', NOW(), NOW()),
        ('Usuarios', NOW(), NOW()),
        ('Solicitudes', NOW(), NOW()),
        ('Edificios', NOW(), NOW()),
        ('Oficinas', NOW(), NOW()),
        ('Mobiliario', NOW(), NOW()),
        ('Servicios', NOW(), NOW()),
        ('Idiomas atencion', NOW(), NOW()),
        ('Consumibles', NOW(), NOW()),
        ('Notificacion push', NOW(), NOW()),
        ('Notificacion email', NOW(), NOW()),
        ('Usuario sistema', NOW(), NOW()),
        ('Configuracion', NOW(), NOW());
		");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){}
}
