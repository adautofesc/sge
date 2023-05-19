<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome',250);
            $table->enum('tipo',['interno','externo','privado']); //interno = alunos e funcionarios da fesc, externo = outros
            $table->enum('status',['espera','andamento','encerrado']);
            $table->enum('incricoes',['abertas','online','presencial','fechadas']);
            $table->date('data_inicio');
            $table->date('data_termino');
            $table->time('horario_inicio');
            $table->time('horario_termino');
            $table->enum('frequencia',['unico','semanal','quinzenal','mensal','bimensal']);
            $table->string('dias_semana',25);
            $table->unsignedInteger('responsavel');
            $table->unsignedInteger('parceria');
            $table->unsignedInteger('sala')->nullable();
            $table->string('local',100)->nullable();
            $table->string('desc',500)->nullable();
            $table->enum('pago',['sim','nao']);//é um evento cobrado
            $table->decimal('valor',10,5);//valor da inscrição       
            $table->foreign('responsavel')->references('id')->on('pessoas')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('parceria')->references('id')->on('parceria')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('eventos');
    }
}
