<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJornadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jornadas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('pessoa');
            $table->unsignedInteger('sala');
            $table->string('dias_semana',25);           
            $table->time('hora_inicio');
            $table->time('hora_termino');
            $table->date('inicio');
            $table->date('termino')->nullable();
            $table->enum('tipo', ['HTPC','HTPI','Projeto','Aula','Translado']);
            $table->enum('status',['ativa','inativa','solicitada']);
            $table->foreign('pessoa')->references('id')->on('pessoas')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('sala')->references('id')->on('salas')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jornadas');
    }
}
