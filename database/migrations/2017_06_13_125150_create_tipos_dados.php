<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiposDados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('tipos_dados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo');
            $table->string('desc');
        });
        Schema::create('recursos_sistema', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('desc');
            $table->string('link');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipos_dados');
        Schema::dropIfExists('tipos_dados');
    }
}
