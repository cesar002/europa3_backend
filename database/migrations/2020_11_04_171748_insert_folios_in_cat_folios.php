<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertFoliosInCatFolios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
		DB::insert('INSERT cat_folios(folio, descripcion, consecutivo, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())', ['EUOP', 'Folio de oficinas privadas', 0]);
		DB::insert('INSERT cat_folios(folio, descripcion, consecutivo, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())', ['EUSJ', 'Folio de sala de juntas', 0]);
		DB::insert('INSERT cat_folios(folio, descripcion, consecutivo, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())', ['EUOV', 'Folio de oficinas virtuales', 0]);
		DB::insert('INSERT cat_folios(folio, descripcion, consecutivo, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())', ['EUIN', 'Folios de insumos comprados', 0]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){}
}
