<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 30);
            $table->unsignedInteger('local');
            $table->unsignedInteger('capacidade');
            $table->double('metragem');
            $table->enum('status',['funcionando','parada']);
            $table->string('posicaogps', 255);
            $table->string('descricao', 300);
            $table->string('obs', 300);
            $table->timestamps();

            $table->foreign('local')->references('id')->on('locais')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salas');
    }
}
