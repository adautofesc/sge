<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsoLivresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uso_livres', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('atendido');
            $table->unsignedInteger('responsavel');
            $table->unsignedInteger('sala');        
            $table->time('hora_inicio');
            $table->time('hora_termino')->nullable();
            $table->date('inicio');
            $table->enum('atividade', ['trabalho','estudo','serviço público','recreação','comunicação'])->nullable();
            $table->foreign('atendido')->references('id')->on('pessoas')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('responsavel')->references('id')->on('pessoas')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('sala')->references('id')->on('salas')->onDelete('restrict')->onUpdate('cascade');
    
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uso_livres');
    }
}
