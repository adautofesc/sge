<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAulaDadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aula_dados', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('aula');
            $table->string('valor',300);
            $table->timestamps();
            $table->foreign('aula')->references('id')->on('aulas')->onDelete('restrict')->onUpdate('cascade');
            $table->enum('dado',['conteudo','ocorrencia','cancelamento','substituto','adiamento','atribuicao']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aula_dados');
    }
}
