<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('cursos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome',150);
            $table->unsignedInteger('programa');
            $table->string('desc',300);
            $table->unsignedInteger('vagas');
            $table->unsignedInteger('carga')->nullable();
            $table->decimal('valor',5,2);
            $table->foreign('programa')->
                references('id')->
                on('programas')->
                onDelete('restrict')->
                onUpdate('cascade');
        });

        Schema::create('requisitos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome',150);


        });

        
        Schema::create('grades', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('curso');
            $table->unsignedInteger('disciplina');
            $table->boolean('obrigatoria');
            $table->foreign('curso')->
                references('id')->
                on('cursos')->
                onDelete('restrict')->
                onUpdate('cascade');
            $table->foreign('disciplina')->
                references('id')->
                on('disciplinas')->
                onDelete('restrict')->
                onUpdate('cascade');
            

        });
        Schema::create('cursos_requisitos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('curso');
            $table->unsignedInteger('requisito');
            $table->boolean('obrigatorio');
            $table->foreign('curso')->
                references('id')->
                on('cursos')->
                onDelete('restrict')->
                onUpdate('cascade');
             $table->foreign('requisito')->
                references('id')->
                on('requisitos')->
                onDelete('restrict')->
                onUpdate('cascade');
            
        });

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cursos');
    }
}
