<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAtendimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atendimentos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('atendente');
            $table->unsignedInteger('usuario');
            $table->string('descricao',150)->nullable();
            $table->timestamps();
            $table->foreign('atendente')->references('id')->on('pessoas')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('usuario')->references('id')->on('pessoas')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atendimentos');
    }
}
