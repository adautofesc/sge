<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFichaTecnicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fichas_tecnicas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('programa');
            $table->foreign('programa')->
                references('id')->
                on('programas')->
                onDelete('restrict')->
                onUpdate('cascade');
            $table->unsignedInteger('docente');
            $table->foreign('docente')->
                references('id')->
                on('pessoas')->
                onDelete('restrict')->
                onUpdate('cascade');
            $table->string('curso',200);
            $table->string('objetivo',500);
            $table->unsignedTinyInteger('idade_minima');
            $table->unsignedTinyInteger('idade_maxima');
            $table->string('requisitos',500);
            $table->unsignedTinyInteger('carga');
            $table->enum('periodicidade',['quinzenal','mensal','bimestral','trimestral','semestral','anual','eventual','ND']);
            $table->string('dias_semana',25);
            $table->date('data_inicio');
            $table->date('data_termino')->nullable();
            $table->time('hora_inicio');
            $table->time('hora_termino');
            $table->unsignedTinyInteger('lotacao_minima');
            $table->unsignedTinyInteger('lotacao_maxima');
            $table->unsignedInteger('valor');
            $table->unsignedInteger('local');
            $table->foreign('local')->
                references('id')->
                on('locais')->
                onDelete('restrict')->
                onUpdate('cascade');
            
            $table->unsignedInteger('sala');
            $table->foreign('sala')->
                references('id')->
                on('salas')->
                onDelete('restrict')->
                onUpdate('cascade');
            $table->enum('status',['docente','coordenacao','diretoria','administracao','presidencia','execucao','negado']);
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
        Schema::dropIfExists('ficha_tecnicas');
    }
}
