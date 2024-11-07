<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurmaLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turma_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('turma');
            $table->string('evento',200);
            $table->dateTime('data');
            $table->unsignedInteger('pessoa');
            $table->foreign('turma')->references('id')->on('turmas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('pessoa')->references('id')->on('pessoas')->onDelete('cascade')->onUpdate('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turma_logs');
    }
}
