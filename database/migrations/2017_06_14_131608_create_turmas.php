<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTurmas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turmas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });
        Schema::create('turmas_dados', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });
        Schema::create('turmas_disciplinas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });
        Schema::create('turmas_disciplinas_dados', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });
        Schema::create('alunos_turmas_disciplinas', function (Blueprint $table) {
            $table->increments('id');
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
        Schema::dropIfExists('turmas');
        Schema::dropIfExists('turmas_dados');
        Schema::dropIfExists('turmas_disciplinas');
        Schema::dropIfExists('turmas_disciplinas_dados');
        Schema::dropIfExists('alunos_turmas_disciplinas');
    }
}
