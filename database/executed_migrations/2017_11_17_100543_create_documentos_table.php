<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('tipo_documento',['Termo de matrícula','Contrato','Cessão de Imagem','Atestado de matrícula']);
            $table->enum('tipo_objeto',['Aluno','Turma','Curso','Programa','Parceria','Global']);
            $table->unsignedInteger('objeto');
            $table->text('conteudo')->nullable();
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
        Schema::dropIfExists('documentos');
    }
}
