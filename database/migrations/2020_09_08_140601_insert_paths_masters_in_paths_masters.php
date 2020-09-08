<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InsertPathsMastersInPathsMasters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

		$pathDocumentos = DB::select('SELECT UUID() AS uuid');
		$pathImage = DB::select('SELECT UUID() AS uuid');
		$pathUserAvatar = DB::select('SELECT UUID() AS uuid');

		DB::insert('INSERT INTO paths_master(nombre, path, created_at, updated_at) VALUES (?, ?, NOW(), NOW())',
					['documentos', $pathDocumentos[0]->uuid]);

		DB::insert('INSERT INTO paths_master(nombre, path, created_at, updated_at) VALUES (?, ?, NOW(), NOW())',
					['imagenes', $pathImage[0]->uuid]);

		DB::insert('INSERT INTO path_images(path_master_id, nombre, path, created_at, updated_at) VALUES(?, ?, ?,NOW(), NOW())',
					[2, 'Avatar admin', $pathUserAvatar[0]->uuid]);

		Storage::makeDirectory($pathDocumentos[0]->uuid);
		Storage::makeDirectory($pathImage[0]->uuid);
		Storage::makeDirectory("{$pathImage[0]->uuid}/{$pathUserAvatar[0]->uuid}");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){}
}
