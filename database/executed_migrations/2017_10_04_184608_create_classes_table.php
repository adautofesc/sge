<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('matricula');
            $table->unsignedInteger('turma');
            $table->unsignedInteger('status');
            $table->timestamps();
            $table->foreign('matricula')->references('id')->on('matriculas')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('turma')->references('id')->on('turmas')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classes');
    }
}
