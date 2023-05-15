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
            $table->string('nome',200);
            $table->enum('tipo',['interno','externo','privado']);
            $table->date('data_inicio');
            $table->date('data_termino');
            $table->time('horario_inicio');
            $table->time('horario_termino');
            $table->string('dias_semana',25);
            $table->unsignedInteger('responsavel');
            $table->unsignedInteger('parceria');
            $table->unsignedInteger('sala')->nullable();
            $table->enum('auto_insc',['sim','nao']);
            $table->string('obs',200)->nullable();
            $table->enum('pago',['sim','nao']);//é um evento cobrado
            $table->decimal('valor',10,5);
            $table->enum('status',['cadastrado','inscricao','encerrado']);
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
