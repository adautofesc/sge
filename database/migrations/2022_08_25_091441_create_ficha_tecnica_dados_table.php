<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFichaTecnicaDadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ficha_tecnica_dados', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ficha');         
            $table->enum('dado',['log']);
            $table->string('conteudo',300);
            $table->unsignedInteger('agente');
            $table->foreign('agente')->
                references('id')->
                on('pessoas')->
                onDelete('restrict')->
                onUpdate('cascade');

            $table->timestamps();
            $table->foreign('ficha')-> references('id')->on('fichas_tecnicas')-> onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ficha_tecnica_dados');
    }
}
