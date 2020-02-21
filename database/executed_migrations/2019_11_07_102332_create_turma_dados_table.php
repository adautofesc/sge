<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTurmaDadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turma_dados', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('turma');
            $table->enum('tipo',['professor_extra']);
            $table->string('dado',300);
            $table->foreign('turma')->references('id')->on('turmas')->onDelete('cascade')->onUpdate('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turma_dados');
    }
}
