<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanoEnsinoDadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plano_ensino_dados', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('plano');         
            $table->enum('dado',['objetivo','atividade']);
            $table->string('conteudo',300);
            $table->unsignedTinyInteger('ordem');
            $table->string('recursos',100);
            $table->timestamps();
            $table->foreign('plano')-> references('id')->on('planos_ensino')-> onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plano_ensino_dados');
    }
}
