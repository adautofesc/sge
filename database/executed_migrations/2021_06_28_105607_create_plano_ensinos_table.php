<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanoEnsinosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planos_ensino', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('docente');
            $table->foreign('docente')->
                references('id')->
                on('pessoas')->
                onDelete('restrict')->
                onUpdate('cascade');
            $table->string('curso',200);
            $table->unsignedTinyInteger('carga');
            
            $table->string('habilidades_gerais',200);
            $table->string('habilidades_especificas',200);
            $table->string('conteudo_programatico',500);
            $table->string('procedimentos_ensino',500);
            $table->string('instrumentos_avaliacao',200);
            $table->string('bibliografia_basica',300);

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
        Schema::dropIfExists('planos_ensino');
    }
}
