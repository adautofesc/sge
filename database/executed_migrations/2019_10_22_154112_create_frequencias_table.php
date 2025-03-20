<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrequenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frequencias', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('aula');
            $table->unsignedInteger('aluno');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('aula')->references('id')->on('aulas')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('aluno')->references('id')->on('pessoas')->onDelete('restrict')->onUpdate('cascade');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frequencias');
    }
}
