<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertSizeInCatSizes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
		DB::unprepared("
			INSERT INTO cat_size_oficinas(size_name, created_at, updated_at) VALUES
			('Chica', NOW(), NOW()),
			('Mediana', NOW(), NOW()),
			('Grande', NOW(), NOW());
		");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){}
}
